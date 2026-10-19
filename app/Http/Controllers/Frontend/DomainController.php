<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DomainOrder;
use App\Models\PaymentSetting;
use Razorpay\Api\Api;
use Illuminate\Http\Request;
use App\Services\OpenProviderService;


class DomainController extends Controller
{

    public function domainNameRegistration()
    {
        return view('frontend.domain.domain-name-registration');
    }

    public function checkDomain(Request $request, OpenProviderService $service)
    {
        $request->validate([
            'domain' => 'required'
        ]);

        $result = $service->checkDomain($request->domain);

        return view('frontend.domain.domain-search-result', compact('result'));
    }

    public function suggestions(Request $request, OpenProviderService $service)
    {
        $input = trim($request->input('keyword', $request->input('domain', '')));
        if (empty($input) || strlen($input) < 2) {
            return response()->json(['success' => false, 'keyword' => '', 'suggestions' => []]);
        }

        $input = strtolower($input);
        $input = preg_replace('/^https?:\/\//i', '', $input);
        $input = preg_replace('/^www\./i', '', $input);
        $input = rtrim($input, '/');

        $parts = explode('.', $input);
        $keyword = $parts[0];
        $selectedExt = count($parts) > 1 && !empty($parts[1]) ? '.' . implode('.', array_slice($parts, 1)) : '';

        $tlds = ['.com', '.in', '.co.in', '.org', '.net', '.store', '.info', '.co', '.tech', '.online'];

        if ($selectedExt) {
            $tlds = array_values(array_unique(array_merge([$selectedExt], $tlds)));
        }

        $domainsToCheck = [];
        foreach ($tlds as $tld) {
            $domainsToCheck[] = [
                'name' => $keyword,
                'extension' => ltrim($tld, '.'),
            ];
        }

        $opResults = [];
        try {
            $login = $service->login();
            $token = $login['data']['token'] ?? null;
            if ($token) {
                $baseUrl = config('services.openprovider.base_url');
                $response = \Illuminate\Support\Facades\Http::timeout(20)->connectTimeout(10)->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                ])->post($baseUrl . '/domains/check', [
                    'domains' => $domainsToCheck,
                    'with_price' => true,
                ])->json();

                if (isset($response['data']['results'])) {
                    foreach ($response['data']['results'] as $item) {
                        $opResults[$item['domain']] = $item;
                    }
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Domain suggestions check error: ' . $e->getMessage());
        }

        $defaultPrices = [
            '.com' => 1034.64,
            '.in' => 599.00,
            '.co.in' => 399.00,
            '.org' => 999.00,
            '.net' => 1199.00,
            '.store' => 299.00,
            '.info' => 499.00,
            '.co' => 899.00,
            '.tech' => 199.00,
            '.online' => 149.00,
        ];

        $suggestions = [];
        foreach ($tlds as $tld) {
            $fullDomain = $keyword . $tld;
            $opData = $opResults[$fullDomain] ?? null;

            $isAvailable = false;
            $price = $defaultPrices[$tld] ?? 999.00;
            $currency = 'INR';

            if ($opData) {
                $status = strtolower($opData['status'] ?? '');
                $isAvailable = ($status === 'free');
                if (isset($opData['price']['reseller']['price'])) {
                    $price = $opData['price']['reseller']['price'];
                    $currency = $opData['price']['reseller']['currency'] ?? 'INR';
                } elseif (isset($opData['price']['product']['price'])) {
                    $price = $opData['price']['product']['price'];
                    $currency = $opData['price']['product']['currency'] ?? 'USD';
                }
            }

            $suggestions[] = [
                'domain' => $fullDomain,
                'keyword' => $keyword,
                'extension' => $tld,
                'available' => $isAvailable,
                'price' => $price,
                'currency' => $currency,
                'formatted_price' => ($currency === 'INR' ? '₹' : '$') . number_format($price),
            ];
        }

        return response()->json([
            'success' => true,
            'keyword' => $keyword,
            'suggestions' => $suggestions,
        ]);
    }


    public function domainOrder(Request $request)
    {
        $request->validate([
            'domain' => 'required',
            'price' => 'required',
            'auth_code' => 'nullable|string',
        ]);

        if (!auth()->check()) {
            session(['pending_domain_order' => $request->all()]);
            session(['url.intended' => route('domain.order.process')]);
            return redirect()->route('login')->with('info', 'Please login to proceed with your domain order.');
        }

        return $this->processDomainOrder($request->all());
    }

    public function processPendingOrder()
    {
        if (!auth()->check() || !session()->has('pending_domain_order')) {
            return redirect()->route('home');
        }

        $data = session()->pull('pending_domain_order');
        return $this->processDomainOrder($data);
    }

    private function processDomainOrder($data)
    {
        $exists = DomainOrder::where('user_id', auth()->id())
            ->where('domain', $data['domain'])
            ->where('status', 'pending')
            ->exists();
        if ($exists) {
            return redirect()->route('cart')->with('info', 'This domain is already in your cart!');
        }

        $parts = explode('.', $data['domain']);

        $expiresAt = null;
        if (!empty($data['expires_at'])) {
            try {
                $expiresAt = \Carbon\Carbon::parse($data['expires_at'])->toDateString();
            } catch (\Exception $e) {
                $expiresAt = null;
            }
        }

        $order = DomainOrder::create([
            'user_id' => auth()->id(),
            'domain' => $data['domain'],
            'extension' => '.' . ($parts[1] ?? ''),
            'price' => $data['price'],
            'currency' => 'INR',
            'status' => 'pending',
            'type' => !empty($data['auth_code']) ? 'transfer' : 'register',
            'auth_code' => $data['auth_code'] ?? null,
            'expires_at' => $expiresAt,
        ]);

        return redirect()->route('cart')->with('success', 'Domain added to cart successfully!');
    }

    public function bulkDomainOrder(Request $request)
    {
        $request->validate([
            'domains' => 'required|array',
            'domains.*.domain' => 'required|string',
            'domains.*.price' => 'required|numeric',
            'domains.*.auth_code' => 'nullable|string',
        ]);

        if (!auth()->check()) {
            session(['pending_bulk_domain_order' => $request->domains]);
            session(['url.intended' => route('bulk.domain.order.process')]);
            return redirect()->route('login')->with('info', 'Please login to proceed with your bulk domain order.');
        }

        return $this->processBulkDomainOrder($request->domains);
    }

    public function processPendingBulkOrder()
    {
        if (!auth()->check() || !session()->has('pending_bulk_domain_order')) {
            return redirect()->route('home');
        }

        $domains = session()->pull('pending_bulk_domain_order');
        return $this->processBulkDomainOrder($domains);
    }

    private function processBulkDomainOrder($domains)
    {
        $addedCount = 0;
        foreach ($domains as $data) {
            $exists = DomainOrder::where('user_id', auth()->id())
                ->where('domain', $data['domain'])
                ->where('status', 'pending')
                ->exists();
            if ($exists) {
                continue;
            }

            $parts = explode('.', $data['domain']);
            
            DomainOrder::create([
                'user_id' => auth()->id(),
                'domain' => $data['domain'],
                'extension' => '.' . ($parts[1] ?? ''),
                'price' => $data['price'],
                'currency' => 'INR',
                'status' => 'pending',
                'type' => !empty($data['auth_code']) ? 'transfer' : 'register',
                'auth_code' => $data['auth_code'] ?? null,
            ]);
            $addedCount++;
        }

        return redirect()->route('cart')->with('success', $addedCount . ' domains added to cart successfully!');
    }

    public function checkout($id)
    {
        $order = DomainOrder::findOrFail($id);

        $gateway = PaymentSetting::where('gateway', 'Razorpay')
            ->where('is_active', true)
            ->first();


        if (!$gateway) {
            return back()->with('error', 'Razorpay not configured');
        }


        $api = new Api(
            $gateway->key_id,
            $gateway->key_secret
        );


        $basePrice = (float) $order->price;
        $icannFee = 23.00;
        $subtotalWithIcann = $basePrice + $icannFee;
        $discountAmount = 0;
        $coupon = null;

        if (session()->has('coupon')) {
            $coupon = session('coupon');
            if ($coupon['type'] === 'percent') {
                $discountAmount = ($subtotalWithIcann * $coupon['value']) / 100;
            } else {
                $discountAmount = $coupon['value'];
            }
            $discountAmount = min($discountAmount, $subtotalWithIcann);
        }

        $taxableAmount = max(0, $subtotalWithIcann - $discountAmount);
        $gstTax = round($taxableAmount * 0.18, 2);
        $totalAmount = round($taxableAmount + $gstTax, 2);

        $razorpayOrder = $api->order->create([
            'receipt' => 'DOMAIN_' . $order->id,
            'amount'  => (int) round($totalAmount * 100),
            'currency' => 'INR',
        ]);

        $order->update([
            'razorpay_order_id' => $razorpayOrder['id']
        ]);

        return view('frontend.domain.domain-checkout', compact(
            'order',
            'basePrice',
            'icannFee',
            'discountAmount',
            'taxableAmount',
            'gstTax',
            'totalAmount',
            'coupon',
            'gateway',
            'razorpayOrder'
        ));
    }


    public function domainTransfer()
    {
        return view('frontend.domain.domain-transfer');
    }

    public function checkDomainTransfer(Request $request, OpenProviderService $service)
    {
        $request->validate([
            'domain' => 'required|string',
            'auth_code' => 'nullable|string',
        ]);

        $domain = strtolower(trim($request->domain));
        $domain = preg_replace('/^https?:\/\//i', '', $domain);
        $domain = preg_replace('/^www\./i', '', $domain);
        $domain = rtrim($domain, '/');

        $parts = explode('.', $domain);
        if (count($parts) < 2 || empty($parts[0]) || empty(end($parts))) {
            $res = [
                'success' => false,
                'message' => 'Please enter a valid domain name (e.g. example.com).'
            ];
            if ($request->ajax() || $request->wantsJson()) return response()->json($res, 422);
            return back()->withErrors(['domain' => $res['message']]);
        }

        // Get availability & pricing from OpenProvider and WHOIS
        $checkRes = $service->checkDomain($domain);
        $whoisRes = $service->whois($domain);

        $priceInfo = null;
        if (isset($checkRes['data']['results'][0]['price'])) {
            $priceInfo = $checkRes['data']['results'][0]['price'];
        }

        $opStatus = $checkRes['data']['results'][0]['status'] ?? null;
        $isRegistered = $whoisRes['registered'] ?? false;

        $price = 0;
        if (isset($priceInfo['reseller']['price'])) {
            $price = $priceInfo['reseller']['price'];
        } elseif (isset($priceInfo['product']['price'])) {
            $price = $priceInfo['product']['price'];
        } else {
            $price = 999.00;
        }

        $isLocked = str_contains(strtolower($whoisRes['domain_status'] ?? ''), 'clienttransferprohibited') ||
                    str_contains(strtolower($whoisRes['domain_status'] ?? ''), 'servertransferprohibited');

        $remainingYears = 0;
        if (!empty($whoisRes['expiration_date'])) {
            try {
                $expDate = \Carbon\Carbon::parse($whoisRes['expiration_date']);
                $remainingYears = max(0, (int) ceil(now()->floatDiffInYears($expDate, false)));
            } catch (\Exception $e) {
                $remainingYears = 0;
            }
        }
        $maxTransferYears = max(1, min(10, 10 - $remainingYears));

        $res = [
            'success' => true,
            'domain' => $domain,
            'auth_code' => $request->auth_code ?? '',
            'is_registered' => $isRegistered,
            'can_transfer' => $isRegistered || $opStatus === 'active',
            'price' => $price,
            'currency' => 'INR',
            'registrar' => $whoisRes['registrar'] ?? 'N/A',
            'expiration_date' => $whoisRes['expiration_date'] ?? null,
            'max_period' => $maxTransferYears,
            'is_locked' => $isLocked,
            'domain_status' => $whoisRes['domain_status'] ?? 'N/A',
            'message' => ($isRegistered || $opStatus === 'active') ? 'Domain is eligible for transfer to HostLok.' : 'Domain is available for new registration.',
        ];

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json($res);
        }

        return view('frontend.domain.domain-transfer', ['result' => $res]);
    }



    public function bulkDomainTransfer()
    {
        return view('frontend.domain.bulk-domain-transfer');
    }

    public function whoisDomainLookup()
    {
        return view('frontend.domain.whois-domain-lookup');
    }

    public function whoisSearch(Request $request, OpenProviderService $service)
    {
        $request->validate([
            'domain' => 'required|string'
        ]);

        $result = $service->whois($request->domain);

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json($result);
        }

        return view('frontend.domain.whois-domain-lookup', compact('result'));
    }

    public function checkBulkDomainTransfer(Request $request, OpenProviderService $service)
    {
        try {
            $domainsInput = $request->input('domains', []);
            if (!is_array($domainsInput) || empty($domainsInput)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please provide at least one valid domain name.'
                ]);
            }

            $results = [];
            $items = array_slice($domainsInput, 0, 10);

            foreach ($items as $item) {
                $rawDomain = is_array($item) ? ($item['domain'] ?? '') : (string)$item;
                $authCode = is_array($item) ? ($item['auth_code'] ?? '') : '';

                $domain = strtolower(trim($rawDomain));
                $domain = preg_replace('/^https?:\/\//i', '', $domain);
                $domain = preg_replace('/^www\./i', '', $domain);
                $domain = rtrim($domain, '/');

                $parts = explode('.', $domain);
                if (count($parts) < 2 || empty($parts[0]) || empty(end($parts)) || preg_match('/[^a-z0-9.-]/i', $domain)) {
                    $results[] = [
                        'success' => false,
                        'domain' => $rawDomain ?: 'Invalid Input',
                        'message' => 'Invalid domain name format.'
                    ];
                    continue;
                }

                try {
                    $checkRes = $service->checkDomain($domain);
                    $whoisRes = $service->whois($domain);

                    $priceInfo = null;
                    if (isset($checkRes['data']['results'][0]['price'])) {
                        $priceInfo = $checkRes['data']['results'][0]['price'];
                    }

                    $opStatus = $checkRes['data']['results'][0]['status'] ?? null;
                    $isRegistered = $whoisRes['registered'] ?? false;

                    $price = 999.00;
                    if (isset($priceInfo['reseller']['price'])) {
                        $price = $priceInfo['reseller']['price'];
                    } elseif (isset($priceInfo['product']['price'])) {
                        $price = $priceInfo['product']['price'];
                    }

                    $isLocked = str_contains(strtolower($whoisRes['domain_status'] ?? ''), 'clienttransferprohibited') ||
                                str_contains(strtolower($whoisRes['domain_status'] ?? ''), 'servertransferprohibited');

                    $results[] = [
                        'success' => true,
                        'domain' => $domain,
                        'auth_code' => $authCode,
                        'is_registered' => $isRegistered,
                        'can_transfer' => $isRegistered || $opStatus === 'active',
                        'price' => $price,
                        'currency' => 'INR',
                        'registrar' => $whoisRes['registrar'] ?? 'N/A',
                        'is_locked' => $isLocked,
                        'domain_status' => $whoisRes['domain_status'] ?? 'N/A',
                        'message' => ($isRegistered || $opStatus === 'active') ? 'Eligible for transfer.' : 'Available for new registration.',
                    ];
                } catch (\Exception $e) {
                    $results[] = [
                        'success' => false,
                        'domain' => $domain,
                        'message' => 'API Error: ' . $e->getMessage()
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'results' => $results
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Request failed: ' . $e->getMessage()
            ]);
        }
    }

}
