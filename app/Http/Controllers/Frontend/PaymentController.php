<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DomainOrder;
use App\Models\EmailOrder;
use App\Models\HostingOrder;
use App\Models\PaymentSetting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Razorpay\Api\Api;

class PaymentController extends Controller
{

    public function index()
    {
        return view('frontend.payment.index');
    }


    public function createOrder(Request $request)
    {
        $gateway = PaymentSetting::where('gateway','Razorpay')
            ->where('is_active',true)
            ->first();


        if(!$gateway){
            return response()->json([
                'success'=>false,
                'message'=>'Razorpay gateway is not configured.'
            ],404);
        }


        try{

            $api = new Api(
                $gateway->key_id,
                $gateway->key_secret
            );


            $amount = 100;


            $order = $api->order->create([
                'receipt'=>'HOSTLOK_'.strtoupper(Str::random(10)),
                'amount'=>$amount * 100,
                'currency'=>$gateway->currency,
            ]);

            return response()->json([
                'success'=>true,
                'key'=>$gateway->key_id,
                'amount'=>$amount * 100,
                'currency'=>$gateway->currency,
                'order_id'=>$order['id'],
            ]);

        }catch(\Exception $e){

            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ],500);

        }
    }

    public function verifyPayment(Request $request)
    {
        @set_time_limit(120);

        $gateway = PaymentSetting::where('gateway','Razorpay')
            ->where('is_active',true)
            ->first();


        if(!$gateway){
            return response()->json([
                'success'=>false,
                'message'=>'Razorpay gateway not found'
            ],404);
        }


        try{


            $api = new Api(
                $gateway->key_id,
                $gateway->key_secret
            );

            $api->utility->verifyPaymentSignature([

                'razorpay_order_id'=>$request->razorpay_order_id,

                'razorpay_payment_id'=>$request->razorpay_payment_id,

                'razorpay_signature'=>$request->razorpay_signature,

            ]);

            Transaction::create([

                'user_id'=>auth()->id(),

                'gateway'=>'Razorpay',

                'gateway_type'=>'Razorpay',

                'order_id'=>$request->razorpay_order_id,

                'payment_id'=>$request->razorpay_payment_id,

                'transaction_id'=>$request->razorpay_payment_id,

                'amount'=>$request->amount / 100,

                'currency'=>$gateway->currency,

                'payment_status'=>'Paid',

                'response'=>$request->all(),

                'paid_at'=>now(),

            ]);

            $domainOrders = DomainOrder::where(
                'razorpay_order_id',
                $request->razorpay_order_id
            )->get();
            $hostingOrders = HostingOrder::where('razorpay_order_id', $request->razorpay_order_id)->get();
            $emailOrders = EmailOrder::where('razorpay_order_id', $request->razorpay_order_id)->get();

            $setting = \App\Models\Setting::first();
            $cartSubtotal = 0;
            foreach ($domainOrders as $d) {
                $cartSubtotal += ((float)$d->price + 23.00);
            }
            foreach ($hostingOrders as $h) {
                $cartSubtotal += (float)$h->price;
            }
            foreach ($emailOrders as $e) {
                $cartSubtotal += (float)$e->price;
            }
            $backupRemoved = session('remove_backup', false);
            $dailyBackupFee = $backupRemoved ? 0.00 : (float) ($setting->daily_backup_fee ?? 0.00);
            if ($dailyBackupFee > 0) {
                $cartSubtotal += $dailyBackupFee;
            }
            $privacyRemoved = session('remove_privacy', false);
            $domainPrivacyFee = $privacyRemoved ? 0.00 : (float) ($setting->domain_privacy_fee ?? 0.00);
            if ($domainPrivacyFee > 0) {
                $cartSubtotal += $domainPrivacyFee;
            }
            if (count($hostingOrders) > 0) {
                $serverBackupFee = (float) ($setting->server_backup_fee ?? 199.00);
                $serverSecurityFee = (float) ($setting->server_security_fee ?? 299.00);
                foreach ($hostingOrders as $hOrd) {
                    $cText = strtolower(($hOrd->hosting_name ?? '') . ' ' . ($hOrd->plan_name ?? ''));
                    if (str_contains($cText, 'vps') || str_contains($cText, 'dedicated') || str_contains($cText, 'server plan') || str_contains($cText, 'cloud server')) {
                        $hasBackup = session()->has("server_backup_{$hOrd->id}") ? session("server_backup_{$hOrd->id}") : true;
                        $hasSecurity = session()->has("server_security_{$hOrd->id}") ? session("server_security_{$hOrd->id}") : false;
                        if ($hasBackup && $serverBackupFee > 0) $cartSubtotal += $serverBackupFee;
                        if ($hasSecurity && $serverSecurityFee > 0) $cartSubtotal += $serverSecurityFee;
                    }
                }
            }

            $calcDiscount = function($itemBase) use ($cartSubtotal) {
                if (!session()->has('coupon')) return 0.00;
                $coupon = session('coupon');
                $val = (float) ($coupon['value'] ?? 0);
                if ($coupon['type'] === 'percent') {
                    $d = ($itemBase * $val) / 100;
                } else {
                    $d = ($cartSubtotal > 0) ? ($itemBase / $cartSubtotal) * $val : 0;
                }
                return min(round($d, 2), $itemBase);
            };

            foreach ($domainOrders as $domainOrder) {
                
                $initialStatus = ($domainOrder->type === 'transfer') ? 'processing' : 'payment_pending';
                $domainOrder->update([
                    'status' => $initialStatus,
                    'payment_id' => $request->razorpay_payment_id,
                    'payment_response' => $request->all(),
                ]);

                // Create Invoice record for billing
                try {
                    $user = auth()->user();
                    $city = optional($user?->city)->name ?? (is_string($user?->city) ? $user?->city : '');
                    $state = optional($user?->state)->name ?? (is_string($user?->state) ? $user?->state : '');
                    $country = optional($user?->country)->name ?? (is_string($user?->country) ? $user?->country : '');
                    $billingAddress = $user ? implode(', ', array_filter(array_map('trim', [
                        $user->address,
                        $city,
                        $state,
                        $country,
                        $user->zip_code
                    ]))) : '';

                    $icannFee = 23.00;
                    $basePrice = (float) $domainOrder->price + $icannFee;
                    $discountAmount = $calcDiscount($basePrice);
                    $taxableAmount = max(0, $basePrice - $discountAmount);
                    $gstAmount = round($taxableAmount * 0.18, 2);
                    $netTotal  = round($taxableAmount + $gstAmount, 2);

                    $periodStr = ($domainOrder->period ?: 1) . ' Year' . (($domainOrder->period ?: 1) > 1 ? 's' : '');

                    $isTransfer = ($domainOrder->type === 'transfer');
                    $serviceLabel = $isTransfer ? 'Domain Transfer' : 'Domain Registration';

                    \App\Models\Invoice::create([
                        'user_id' => auth()->id(),
                        'invoice_no' => 'INV-DOM-' . time() . '-' . rand(1000, 9999),
                        'payment_id' => $request->razorpay_payment_id,
                        'service_type' => 'Domain',
                        'service_name' => $domainOrder->domain . ($isTransfer ? ' (Transfer)' : ''),
                        'period' => $periodStr,
                        'amount' => $taxableAmount,
                        'gst' => $gstAmount,
                        'vendor_amount' => $taxableAmount,
                        'net_amount' => $netTotal,
                        'payment_status' => 'Paid',
                        'billing_address' => $billingAddress,
                        'invoice_date' => now()->toDateString(),
                        'plan_features' => $serviceLabel . ': ' . $domainOrder->domain . ' (' . $periodStr . ')' . ($isTransfer && $domainOrder->auth_code ? ' | Auth Code: ' . $domainOrder->auth_code : ''),
                    ]);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Invoice creation failed: ' . $e->getMessage());
                }

                // Handle Renewal
                if (session()->has('renewal_domain_' . $domainOrder->id)) {
                    $originalId = session('renewal_domain_' . $domainOrder->id);
                    $originalDomain = DomainOrder::find($originalId);
                    
                    if ($originalDomain && $originalDomain->expires_at) {
                        $originalDomain->expires_at = \Carbon\Carbon::parse($originalDomain->expires_at)->addYear()->toDateString();
                        $originalDomain->save();
                    }
                    
                    $domainOrder->update([
                        'status' => 'renewed',
                        'registered_at' => now()->toDateString(),
                        'expires_at' => now()->addYear()->toDateString(),
                    ]);
                    
                    session()->forget('renewal_domain_' . $domainOrder->id);
                } else {
                    // Register domain in OpenProvider
                    try {
                        $user = auth()->user();
                        if ($user) {
                            $service = new \App\Services\OpenProviderService();
                            
                            // 1. Get or create customer handle
                            $ownerHandle = $user->openprovider_handle;
                            if (!$ownerHandle) {
                                $customerRes = $service->createCustomer($user);
                                if ($customerRes['success']) {
                                    $ownerHandle = $customerRes['handle'];
                                }
                            }
                            
                            if ($ownerHandle) {
                                // 2. Register or Transfer domain
                                if ($domainOrder->type === 'transfer') {
                                    $regRes = $service->transferDomain($domainOrder->domain, $domainOrder->auth_code, $ownerHandle);
                                } else {
                                    $regRes = $service->registerDomain($domainOrder->domain, $ownerHandle, $domainOrder->period);
                                }

                                if ($regRes['success']) {
                                    $domainOrder->update([
                                        'status' => ($domainOrder->type === 'transfer') ? 'processing' : 'registered',
                                        'registered_at' => now()->toDateString(),
                                        'expires_at' => now()->addYears($domainOrder->period ?: 1)->toDateString(),
                                        'provider_domain_id' => $regRes['domain_id'],
                                        'provider_response' => $regRes['data'] ?? null,
                                    ]);
                                } else {
                                    $domainOrder->update([
                                        'status' => ($domainOrder->type === 'transfer') ? 'processing' : 'registered',
                                        'registered_at' => now()->toDateString(),
                                        'expires_at' => now()->addYears($domainOrder->period ?: 1)->toDateString(),
                                        'provider_response' => ['note' => 'Local test activation', 'error' => $regRes['message'] ?? 'API timeout'],
                                    ]);
                                    \Illuminate\Support\Facades\Log::warning('OpenProvider ' . $domainOrder->type . ' API fallback: ' . ($regRes['message'] ?? ''));
                                }
                            } else {
                                $domainOrder->update([
                                    'status' => ($domainOrder->type === 'transfer') ? 'processing' : 'registered',
                                    'registered_at' => now()->toDateString(),
                                    'expires_at' => now()->addYears($domainOrder->period ?: 1)->toDateString(),
                                    'provider_response' => ['note' => 'Local test activation: Customer handle creation fallback'],
                                ]);
                                \Illuminate\Support\Facades\Log::warning('OpenProvider customer handle fallback');
                            }
                        }
                    } catch (\Exception $e) {
                        $domainOrder->update([
                            'status' => ($domainOrder->type === 'transfer') ? 'processing' : 'registered',
                            'registered_at' => now()->toDateString(),
                            'expires_at' => now()->addYears($domainOrder->period ?: 1)->toDateString(),
                            'provider_response' => ['note' => 'Local test activation: ' . $e->getMessage()],
                        ]);
                        \Illuminate\Support\Facades\Log::error('PaymentController OpenProvider registration exception: ' . $e->getMessage());
                    }
                }

            }

            // --- Hosting Order ---
            $hostingOrders = HostingOrder::where('razorpay_order_id', $request->razorpay_order_id)->get();

            foreach ($hostingOrders as $hostingOrder) {
                
                if (session()->has('renewal_hosting_' . $hostingOrder->id)) {
                    $originalId = session('renewal_hosting_' . $hostingOrder->id);
                    $original = HostingOrder::find($originalId);
                    if ($original && $original->expires_at) {
                        $original->expires_at = \Carbon\Carbon::parse($original->expires_at)->addYear();
                        $original->save();
                    }
                    $hostingOrder->update([
                        'status'           => 'renewed',
                        'payment_id'       => $request->razorpay_payment_id,
                        'payment_response' => $request->all(),
                    ]);
                    session()->forget('renewal_hosting_' . $hostingOrder->id);
                } else {
                    $hPeriodLower = strtolower($hostingOrder->period ?? '12');
                    preg_match('/(\d+)/', $hPeriodLower, $hMatches);
                    $hNum = !empty($hMatches[1]) ? (int)$hMatches[1] : 1;

                    if (str_contains($hPeriodLower, 'year')) {
                        $hExpiry = now()->addYears($hNum);
                    } elseif (str_contains($hPeriodLower, 'month')) {
                        $hExpiry = now()->addMonths($hNum);
                    } elseif (in_array($hNum, [1, 3, 6])) {
                        $hExpiry = now()->addMonths($hNum);
                    } else {
                        $hExpiry = ($hNum >= 12) ? now()->addMonths($hNum) : now()->addYears($hNum);
                    }

                    $hostingOrder->update([
                        'status'           => 'active',
                        'payment_id'       => $request->razorpay_payment_id,
                        'payment_response' => $request->all(),
                        'starts_at'        => now(),
                        'expires_at'       => $hExpiry,
                    ]);
                }

                // Create Invoice for hosting
                try {
                    $user = auth()->user();
                    $city = optional($user?->city)->name ?? (is_string($user?->city) ? $user?->city : '');
                    $state = optional($user?->state)->name ?? (is_string($user?->state) ? $user?->state : '');
                    $country = optional($user?->country)->name ?? (is_string($user?->country) ? $user?->country : '');
                    $billingAddress = $user ? implode(', ', array_filter(array_map('trim', [
                        $user->address,
                        $city,
                        $state,
                        $country,
                        $user->zip_code
                    ]))) : '';

                    $basePrice = (float) $hostingOrder->price;
                    $discountAmount = $calcDiscount($basePrice);
                    $taxableAmount = max(0, $basePrice - $discountAmount);
                    $gstAmount = round($taxableAmount * 0.18, 2);
                    $netTotal  = round($taxableAmount + $gstAmount, 2);

                    \App\Models\Invoice::create([
                        'user_id'         => auth()->id(),
                        'invoice_no'      => 'INV-HOS-' . time() . '-' . rand(1000, 9999),
                        'payment_id'      => $request->razorpay_payment_id,
                        'service_type'    => 'Hosting',
                        'service_name'    => $hostingOrder->hosting_name . ' - ' . $hostingOrder->plan_name,
                        'period'          => ucfirst($hostingOrder->period),
                        'amount'          => $taxableAmount,
                        'gst'             => $gstAmount,
                        'vendor_amount'   => $taxableAmount,
                        'net_amount'      => $netTotal,
                        'payment_status'  => 'Paid',
                        'billing_address' => $billingAddress,
                        'invoice_date'    => now()->toDateString(),
                        'plan_features'   => $hostingOrder->hosting_name . ' - ' . $hostingOrder->plan_name . ' (' . ucfirst($hostingOrder->period) . ')',
                    ]);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Hosting Invoice creation failed: ' . $e->getMessage());
                }
            }

            // --- Email Order ---
            $emailOrders = \App\Models\EmailOrder::where('razorpay_order_id', $request->razorpay_order_id)->get();

            foreach ($emailOrders as $emailOrder) {
                
                if (session()->has('renewal_email_' . $emailOrder->id)) {
                    $originalId = session('renewal_email_' . $emailOrder->id);
                    $original = \App\Models\BusinessEmail::find($originalId);
                    if ($original && $original->expiry_date) {
                        $periodLower = strtolower($emailOrder->period ?? '6');
                        preg_match('/(\d+)/', $periodLower, $eMatches);
                        $numPeriod = !empty($eMatches[1]) ? (int)$eMatches[1] : 6;
                        $curExp = \Carbon\Carbon::parse($original->expiry_date);
                        if ($curExp->isPast()) {
                            $curExp = now();
                        }
                        if (str_contains($periodLower, 'year')) {
                            $original->expiry_date = $curExp->addYears($numPeriod)->toDateString();
                        } else {
                            $original->expiry_date = $curExp->addMonths($numPeriod)->toDateString();
                        }
                        $original->save();
                    }
                    $emailOrder->update([
                        'status' => 'renewed'
                    ]);
                    session()->forget('renewal_email_' . $emailOrder->id);
                } else {
                    $emailOrder->update([
                        'status' => 'completed'
                    ]);

                    // Create Invoice for email
                    try {
                        $user = auth()->user();
                        $city = optional($user?->city)->name ?? (is_string($user?->city) ? $user?->city : '');
                        $state = optional($user?->state)->name ?? (is_string($user?->state) ? $user?->state : '');
                        $country = optional($user?->country)->name ?? (is_string($user?->country) ? $user?->country : '');
                        $billingAddress = $user ? implode(', ', array_filter(array_map('trim', [
                            $user->address,
                            $city,
                            $state,
                            $country,
                            $user->zip_code
                        ]))) : '';

                        $basePrice = (float) $emailOrder->price;
                        $discountAmount = $calcDiscount($basePrice);
                        $taxableAmount = max(0, $basePrice - $discountAmount);
                        $gstAmount = round($taxableAmount * 0.18, 2);
                        $netTotal  = round($taxableAmount + $gstAmount, 2);

                        \App\Models\Invoice::create([
                            'user_id'         => auth()->id(),
                            'invoice_no'      => 'INV-EML-' . time() . '-' . rand(1000, 9999),
                            'payment_id'      => $request->razorpay_payment_id,
                            'service_type'    => 'Email',
                            'service_name'    => $emailOrder->provider . ' - ' . $emailOrder->plan_name,
                            'period'          => ucfirst($emailOrder->period),
                            'amount'          => $taxableAmount,
                            'discount'        => $discountAmount,
                            'gst'             => $gstAmount,
                            'vendor_amount'   => $taxableAmount,
                            'net_amount'      => $netTotal,
                            'payment_status'  => 'Paid',
                            'billing_address' => $billingAddress,
                            'invoice_date'    => now()->toDateString(),
                            'plan_features'   => $emailOrder->desired_email . '@' . $emailOrder->domain_name,
                        ]);
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error('Email Invoice creation failed: ' . $e->getMessage());
                    }
                    
                    // Auto create the Business Email
                    try {
                        $periodLower = strtolower($emailOrder->period ?? '12');
                        preg_match('/(\d+)/', $periodLower, $eMatches);
                        $numPeriod = !empty($eMatches[1]) ? (int)$eMatches[1] : 1;
                        if (str_contains($periodLower, 'year')) {
                            $expiryDate = now()->addYears($numPeriod)->toDateString();
                        } else {
                            $expiryDate = now()->addMonths($numPeriod)->toDateString();
                        }

                        \App\Models\BusinessEmail::create([
                            'user_id'           => auth()->id(),
                            'domain'            => $emailOrder->domain_name,
                            'plan_name'         => $emailOrder->provider . ' ' . $emailOrder->plan_name,
                            'email_address'     => $emailOrder->desired_email . '@' . $emailOrder->domain_name,
                            'registration_date' => now()->toDateString(),
                            'expiry_date'       => $expiryDate,
                            'status'            => 'active',
                        ]);
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error('BusinessEmail creation failed: ' . $e->getMessage());
                    }
                }
            }

            // --- Add-on Services Invoices ---
            try {
                $setting = \App\Models\Setting::first();
                $user = auth()->user();
                $city = optional($user?->city)->name ?? (is_string($user?->city) ? $user?->city : '');
                $state = optional($user?->state)->name ?? (is_string($user?->state) ? $user?->state : '');
                $country = optional($user?->country)->name ?? (is_string($user?->country) ? $user?->country : '');
                $billingAddress = $user ? implode(', ', array_filter(array_map('trim', [
                    $user->address,
                    $city,
                    $state,
                    $country,
                    $user->zip_code
                ]))) : '';

                // 1. Daily Backup Fees
                $backupRemoved = session('remove_backup', false);
                $dailyBackupFee = $backupRemoved ? 0.00 : (float) ($setting->daily_backup_fee ?? 0.00);
                if ($dailyBackupFee > 0) {
                    $basePrice = $dailyBackupFee;
                    $discountAmount = $calcDiscount($basePrice);
                    $taxable = max(0, $basePrice - $discountAmount);
                    $gst = round($taxable * 0.18, 2);
                    $net = round($taxable + $gst, 2);

                    \App\Models\Invoice::create([
                        'user_id'         => auth()->id(),
                        'invoice_no'      => 'INV-ADD-' . time() . '-' . rand(1000, 9999),
                        'payment_id'      => $request->razorpay_payment_id,
                        'service_type'    => 'Add-on',
                        'service_name'    => 'Daily Backup Fees',
                        'period'          => '1 Year',
                        'amount'          => $taxable,
                        'discount'        => $discountAmount,
                        'gst'             => $gst,
                        'vendor_amount'   => $taxable,
                        'net_amount'      => $net,
                        'payment_status'  => 'Paid',
                        'billing_address' => $billingAddress,
                        'invoice_date'    => now()->toDateString(),
                        'plan_features'   => 'Daily Automated Offsite Backup Service',
                    ]);
                }

                // 2. Domain Privacy Protection Fee
                $privacyRemoved = session('remove_privacy', false);
                $domainPrivacyFee = $privacyRemoved ? 0.00 : (float) ($setting->domain_privacy_fee ?? 0.00);
                if ($domainPrivacyFee > 0) {
                    $basePrice = $domainPrivacyFee;
                    $discountAmount = $calcDiscount($basePrice);
                    $taxable = max(0, $basePrice - $discountAmount);
                    $gst = round($taxable * 0.18, 2);
                    $net = round($taxable + $gst, 2);

                    \App\Models\Invoice::create([
                        'user_id'         => auth()->id(),
                        'invoice_no'      => 'INV-ADD-' . time() . '-' . rand(1000, 9999),
                        'payment_id'      => $request->razorpay_payment_id,
                        'service_type'    => 'Add-on',
                        'service_name'    => 'Privacy Protection',
                        'period'          => '1 Year',
                        'amount'          => $taxable,
                        'discount'        => $discountAmount,
                        'gst'             => $gst,
                        'vendor_amount'   => $taxable,
                        'net_amount'      => $net,
                        'payment_status'  => 'Paid',
                        'billing_address' => $billingAddress,
                        'invoice_date'    => now()->toDateString(),
                        'plan_features'   => 'WHOIS Privacy Protection Service',
                    ]);
                }

                // 3. Server Add-ons (Auto Backup & Server Security Suite)
                if (isset($hostingOrders)) {
                    $serverBackupFee = (float) ($setting->server_backup_fee ?? 199.00);
                    $serverSecurityFee = (float) ($setting->server_security_fee ?? 299.00);

                    foreach ($hostingOrders as $hOrd) {
                        $cText = strtolower(($hOrd->hosting_name ?? '') . ' ' . ($hOrd->plan_name ?? ''));
                        if (str_contains($cText, 'vps') || str_contains($cText, 'dedicated') || str_contains($cText, 'server plan') || str_contains($cText, 'cloud server')) {
                            $hasBackup = session()->has("server_backup_{$hOrd->id}") ? session("server_backup_{$hOrd->id}") : true;
                            $hasSecurity = session()->has("server_security_{$hOrd->id}") ? session("server_security_{$hOrd->id}") : false;

                            if ($hasBackup && $serverBackupFee > 0) {
                                $basePrice = $serverBackupFee;
                                $discountAmount = $calcDiscount($basePrice);
                                $taxable = max(0, $basePrice - $discountAmount);
                                $gst = round($taxable * 0.18, 2);
                                $net = round($taxable + $gst, 2);

                                \App\Models\Invoice::create([
                                    'user_id'         => auth()->id(),
                                    'invoice_no'      => 'INV-ADD-' . time() . '-' . rand(1000, 9999),
                                    'payment_id'      => $request->razorpay_payment_id,
                                    'service_type'    => 'Add-on',
                                    'service_name'    => 'Auto Backup',
                                    'period'          => ucfirst($hOrd->period),
                                    'amount'          => $taxable,
                                    'discount'        => $discountAmount,
                                    'gst'             => $gst,
                                    'vendor_amount'   => $taxable,
                                    'net_amount'      => $net,
                                    'payment_status'  => 'Paid',
                                    'billing_address' => $billingAddress,
                                    'invoice_date'    => now()->toDateString(),
                                    'plan_features'   => 'Server Auto Backup Fee (' . $hOrd->hosting_name . ')',
                                ]);
                            }

                            if ($hasSecurity && $serverSecurityFee > 0) {
                                $basePrice = $serverSecurityFee;
                                $discountAmount = $calcDiscount($basePrice);
                                $taxable = max(0, $basePrice - $discountAmount);
                                $gst = round($taxable * 0.18, 2);
                                $net = round($taxable + $gst, 2);

                                \App\Models\Invoice::create([
                                    'user_id'         => auth()->id(),
                                    'invoice_no'      => 'INV-ADD-' . time() . '-' . rand(1000, 9999),
                                    'payment_id'      => $request->razorpay_payment_id,
                                    'service_type'    => 'Add-on',
                                    'service_name'    => 'Server Security Suite',
                                    'period'          => ucfirst($hOrd->period),
                                    'amount'          => $taxable,
                                    'discount'        => $discountAmount,
                                    'gst'             => $gst,
                                    'vendor_amount'   => $taxable,
                                    'net_amount'      => $net,
                                    'payment_status'  => 'Paid',
                                    'billing_address' => $billingAddress,
                                    'invoice_date'    => now()->toDateString(),
                                    'plan_features'   => 'Server Security Protection Suite (' . $hOrd->hosting_name . ')',
                                ]);
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Add-on Invoices creation failed: ' . $e->getMessage());
            }

            // Clear cart session variables
            session()->forget(['coupon', 'backup', 'privacy', 'remove_backup', 'remove_privacy']);

            return response()->json([

                'success'=>true,

                'redirect'=>route('payment.success')

            ]);

        }catch(\Throwable $e){
            \Illuminate\Support\Facades\Log::error('verifyPayment Exception: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());


            return response()->json([

                'success'=>false,

                'message'=>$e->getMessage()

            ],500);

        }

    }

    public function success()
    {
        return view('frontend.payment.success');
    }

    public function failed()
    {
        return view('frontend.payment.failed');
    }

}
