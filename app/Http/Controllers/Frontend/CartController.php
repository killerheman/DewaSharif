<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CartController extends Controller
{

    public function cart()
    {
        $pendingDomains = collect();
        $pendingHostings = collect();
        $pendingEmails = collect();

        if (auth()->check()) {
            $userId = auth()->id();
            
            if (class_exists(\App\Models\DomainOrder::class)) {
                $pendingDomains = \App\Models\DomainOrder::where('user_id', $userId)
                                    ->where('status', 'pending')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
            }

            if (class_exists(\App\Models\HostingOrder::class)) {
                $pendingHostings = \App\Models\HostingOrder::with(['plan', 'hosting'])
                                    ->where('user_id', $userId)
                                    ->where('status', 'pending')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
            }

            if (class_exists(\App\Models\EmailOrder::class)) {
                $pendingEmails = \App\Models\EmailOrder::where('user_id', $userId)
                                    ->where('status', 'pending')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
            }
        }

        $setting = \App\Models\Setting::first();
        $backupRemoved = session('remove_backup', false);
        $privacyRemoved = session('remove_privacy', false);

        $dailyBackupFee = $backupRemoved ? 0.00 : (float) ($setting->daily_backup_fee ?? 0.00);
        $domainPrivacyFee = $privacyRemoved ? 0.00 : (float) ($setting->domain_privacy_fee ?? 0.00);
        $serverBackupFee = (float) ($setting->server_backup_fee ?? 199.00);
        $serverSecurityFee = (float) ($setting->server_security_fee ?? 299.00);

        return view('frontend.cart.cart', compact(
            'pendingDomains', 
            'pendingHostings', 
            'pendingEmails',
            'setting',
            'dailyBackupFee',
            'domainPrivacyFee',
            'serverBackupFee',
            'serverSecurityFee',
            'backupRemoved',
            'privacyRemoved'
        ));
    }

    public function toggleAddon(Request $request)
    {
        $addon = $request->input('addon');
        $action = $request->input('action');
        $itemId = $request->input('item_id');

        if ($addon === 'backup') {
            session(['remove_backup' => ($action === 'remove')]);
        } elseif ($addon === 'privacy') {
            session(['remove_privacy' => ($action === 'remove')]);
        } elseif ($addon === 'server_backup') {
            if ($itemId) {
                session(["server_backup_{$itemId}" => ($action === 'add')]);
            } else {
                $userId = auth()->id();
                if ($userId && class_exists(\App\Models\HostingOrder::class)) {
                    $pendingHostings = \App\Models\HostingOrder::with('plan')
                        ->where('user_id', $userId)
                        ->where('status', 'pending')
                        ->get();
                    foreach ($pendingHostings as $pH) {
                        session(["server_backup_{$pH->id}" => ($action === 'add')]);
                    }
                }
            }
        } elseif ($addon === 'server_security') {
            if ($itemId) {
                session(["server_security_{$itemId}" => ($action === 'add')]);
            } else {
                $userId = auth()->id();
                if ($userId && class_exists(\App\Models\HostingOrder::class)) {
                    $pendingHostings = \App\Models\HostingOrder::with('plan')
                        ->where('user_id', $userId)
                        ->where('status', 'pending')
                        ->get();
                    foreach ($pendingHostings as $pH) {
                        session(["server_security_{$pH->id}" => ($action === 'add')]);
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Addon updated successfully.'
        ]);
    }

    private function calculateCartTotals()
    {
        $userId = auth()->id();
        $pendingDomains = collect();
        $pendingHostings = collect();
        $pendingEmails = collect();

        if (class_exists(\App\Models\DomainOrder::class)) {
            $pendingDomains = \App\Models\DomainOrder::where('user_id', $userId)
                                ->where('status', 'pending')
                                ->get();
        }
        if (class_exists(\App\Models\HostingOrder::class)) {
            $pendingHostings = \App\Models\HostingOrder::with(['plan', 'hosting'])
                                ->where('user_id', $userId)
                                ->where('status', 'pending')
                                ->get();
        }
        if (class_exists(\App\Models\EmailOrder::class)) {
            $pendingEmails = \App\Models\EmailOrder::where('user_id', $userId)
                                ->where('status', 'pending')
                                ->get();
        }

        $setting = \App\Models\Setting::first();
        $backupRemoved = session('remove_backup', false);
        $privacyRemoved = session('remove_privacy', false);

        $dailyBackupFee = $backupRemoved ? 0.00 : (float) ($setting->daily_backup_fee ?? 0.00);
        $domainPrivacyFee = $privacyRemoved ? 0.00 : (float) ($setting->domain_privacy_fee ?? 0.00);
        $serverBackupFee = (float) ($setting->server_backup_fee ?? 199.00);
        $serverSecurityFee = (float) ($setting->server_security_fee ?? 299.00);

        $totalServerBackupFee = 0.00;
        $totalServerSecurityFee = 0.00;
        $serverBackupCount = 0;
        $serverSecurityCount = 0;
        $hasServerInCart = false;

        foreach ($pendingHostings as $pH) {
            $isServer = false;
            if ($pH->plan && $pH->plan->common_type === \App\Models\Server::class) {
                $isServer = true;
            } else {
                $cText = strtolower(($pH->hosting_name ?? '') . ' ' . ($pH->plan_name ?? ''));
                if (str_contains($cText, 'vps') || str_contains($cText, 'dedicated') || str_contains($cText, 'server plan') || str_contains($cText, 'cloud server')) {
                    $isServer = true;
                }
            }

            if ($isServer) {
                $hasServerInCart = true;
                $hasBackup = session()->has("server_backup_{$pH->id}") 
                    ? session("server_backup_{$pH->id}") 
                    : true;

                $hasSecurity = session()->has("server_security_{$pH->id}") 
                    ? session("server_security_{$pH->id}") 
                    : false;

                if ($hasBackup) {
                    $totalServerBackupFee += $serverBackupFee;
                    $serverBackupCount++;
                }
                if ($hasSecurity) {
                    $totalServerSecurityFee += $serverSecurityFee;
                    $serverSecurityCount++;
                }
            }
        }

        $domainIcannFee = $pendingDomains->count() * 23.00;
        
        $itemBases = [];
        foreach ($pendingDomains as $d) {
            $itemBases[] = (float)$d->price + 23.00;
        }
        foreach ($pendingHostings as $h) {
            $itemBases[] = (float)$h->price;
        }
        foreach ($pendingEmails as $e) {
            $itemBases[] = (float)$e->price;
        }
        if ($dailyBackupFee > 0) {
            $itemBases[] = (float)$dailyBackupFee;
        }
        if ($domainPrivacyFee > 0) {
            $itemBases[] = (float)$domainPrivacyFee;
        }
        if ($totalServerBackupFee > 0) {
            $itemBases[] = (float)$totalServerBackupFee;
        }
        if ($totalServerSecurityFee > 0) {
            $itemBases[] = (float)$totalServerSecurityFee;
        }

        $subtotal = array_sum($itemBases);

        $discountAmount = 0;
        $coupon = null;
        if (session()->has('coupon')) {
            $coupon = session('coupon');
            if ($coupon['type'] === 'percent') {
                $discountAmount = ($subtotal * $coupon['value']) / 100;
            } else {
                $discountAmount = $coupon['value'];
            }
            $discountAmount = min($discountAmount, $subtotal);
        }

        $totalGst = 0;
        $totalAmount = 0;

        foreach ($itemBases as $base) {
            $itemDisc = ($subtotal > 0) ? ($base / $subtotal) * $discountAmount : 0;
            $taxable = max(0, $base - $itemDisc);
            $gst = round($taxable * 0.18, 2);
            $net = round($taxable + $gst, 2);
            $totalGst += $gst;
            $totalAmount += $net;
        }

        $taxableAmount = max(0, $subtotal - $discountAmount);

        return [
            'subtotal'         => $subtotal,
            'domain_icann_fee' => $domainIcannFee,
            'discount_amount'  => $discountAmount,
            'taxable_amount'   => $taxableAmount,
            'gst_tax'          => round($totalGst, 2),
            'amount'           => round($totalAmount, 2),
            'coupon'           => $coupon,
        ];
    }

    public function applyCoupon(Request $request)
    {
        $code = strtoupper(trim($request->code));
        $coupon = Coupon::where('code', $code)
                        ->where('is_active', true)
                        ->where(function($query) {
                            $query->whereNull('expiry_date')
                                  ->orWhere('expiry_date', '>=', now()->toDateString());
                        })
                        ->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired coupon code.']);
        }

        session(['coupon' => [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => (float)$coupon->value
        ]]);

        $totals = $this->calculateCartTotals();

        return response()->json([
            'success' => true, 
            'message' => 'Coupon applied successfully!',
            'coupon' => session('coupon'),
            'discount_amount' => number_format($totals['discount_amount'], 2),
            'gst_tax' => number_format($totals['gst_tax'], 2),
            'amount' => number_format($totals['amount'], 2),
            'raw_amount' => (int) round($totals['amount'] * 100),
        ]);
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        $totals = $this->calculateCartTotals();

        return response()->json([
            'success' => true, 
            'message' => 'Coupon removed successfully.',
            'gst_tax' => number_format($totals['gst_tax'], 2),
            'amount' => number_format($totals['amount'], 2),
            'raw_amount' => (int) round($totals['amount'] * 100),
        ]);
    }

    public function removeDomain($id)
    {
        if (class_exists(\App\Models\DomainOrder::class)) {
            \App\Models\DomainOrder::where('id', $id)->where('user_id', auth()->id())->delete();
        }
        return redirect()->route('cart')->with('success', 'Domain removed from cart successfully.');
    }

    public function removeHosting($id)
    {
        if (class_exists(\App\Models\HostingOrder::class)) {
            \App\Models\HostingOrder::where('id', $id)->where('user_id', auth()->id())->delete();
        }
        return redirect()->route('cart')->with('success', 'Hosting plan removed from cart successfully.');
    }

    public function removeEmail($id)
    {
        if (class_exists(\App\Models\EmailOrder::class)) {
            \App\Models\EmailOrder::where('id', $id)->where('user_id', auth()->id())->delete();
        }
        return redirect()->route('cart')->with('success', 'Email plan removed from cart successfully.');
    }

    public function addRenewal($type, $id)
    {
        $userId = auth()->id();
        
        if ($type === 'domain' && class_exists(\App\Models\DomainOrder::class)) {
            $original = \App\Models\DomainOrder::where('id', $id)->where('user_id', $userId)->first();
            if ($original) {
                $exists = \App\Models\DomainOrder::where('domain', $original->domain)
                            ->where('type', 'renew')
                            ->where('status', 'pending')
                            ->exists();
                if (!$exists) {
                    $newOrder = $original->replicate();
                    $newOrder->status = 'pending';
                    $newOrder->razorpay_order_id = null;
                    $newOrder->payment_response = null;
                    $newOrder->save();
                    
                    session(['renewal_domain_' . $newOrder->id => $original->id]);
                }
            }
        } elseif ($type === 'hosting' && class_exists(\App\Models\HostingOrder::class)) {
            $original = \App\Models\HostingOrder::where('id', $id)->where('user_id', $userId)->first();
            if ($original) {
                $exists = \App\Models\HostingOrder::where('hosting_id', $original->hosting_id)
                            ->where('status', 'pending')
                            ->exists();
                if (!$exists) {
                    $newOrder = $original->replicate();
                    $newOrder->status = 'pending';
                    $newOrder->razorpay_order_id = null;
                    $newOrder->payment_response = null;
                    $newOrder->save();
                    
                    session(['renewal_hosting_' . $newOrder->id => $original->id]);
                }
            }
        } elseif ($type === 'email' && class_exists(\App\Models\EmailOrder::class)) {
            $businessEmail = \App\Models\BusinessEmail::where('id', $id)->where('user_id', $userId)->first();
            if ($businessEmail) {
                $original = \App\Models\EmailOrder::where('domain_name', $businessEmail->domain)
                                ->where('user_id', $userId)
                                ->orderBy('id', 'desc')
                                ->first();
                if ($original) {
                    $exists = \App\Models\EmailOrder::where('domain_name', $original->domain_name)
                                ->where('status', 'pending')
                                ->exists();
                    if (!$exists) {
                        $newOrder = $original->replicate();
                        $newOrder->status = 'pending';
                        $newOrder->razorpay_order_id = null;
                        $newOrder->save();
                        
                        session(['renewal_email_' . $newOrder->id => $businessEmail->id]);
                    }
                }
            }
        }

        return redirect()->route('cart.checkout')->with('success', ucfirst($type) . ' renewal added to cart successfully. Proceed to payment.');
    }

    public function customerBillingDetails()
    {
        return view('frontend.cart.cart-billing-details');
    }

    public function customerBillingConfirmation()
    {
        return view('frontend.cart.cart-billing-confirmation');
    }

    public function checkout()
    {
        $userId = auth()->id();
        
        $pendingDomains = collect();
        $pendingHostings = collect();
        $pendingEmails = collect();

        if (class_exists(\App\Models\DomainOrder::class)) {
            $pendingDomains = \App\Models\DomainOrder::where('user_id', $userId)
                                ->where('status', 'pending')
                                ->get();
        }

        if (class_exists(\App\Models\HostingOrder::class)) {
            $pendingHostings = \App\Models\HostingOrder::with(['plan', 'hosting'])
                                ->where('user_id', $userId)
                                ->where('status', 'pending')
                                ->get();
        }

        if (class_exists(\App\Models\EmailOrder::class)) {
            $pendingEmails = \App\Models\EmailOrder::where('user_id', $userId)
                                ->where('status', 'pending')
                                ->get();
        }

        if ($pendingDomains->isEmpty() && $pendingHostings->isEmpty() && $pendingEmails->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $gateway = \App\Models\PaymentSetting::where('gateway', 'Razorpay')
            ->where('is_active', true)
            ->first();

        if (!$gateway) {
            return redirect()->route('cart')->with('error', 'Razorpay not configured');
        }

        $api = new \Razorpay\Api\Api($gateway->key_id, $gateway->key_secret);

        $setting = \App\Models\Setting::first();
        $backupRemoved = session('remove_backup', false);
        $privacyRemoved = session('remove_privacy', false);

        $dailyBackupFee = $backupRemoved ? 0.00 : (float) ($setting->daily_backup_fee ?? 0.00);
        $domainPrivacyFee = $privacyRemoved ? 0.00 : (float) ($setting->domain_privacy_fee ?? 0.00);
        $serverBackupFee = (float) ($setting->server_backup_fee ?? 199.00);
        $serverSecurityFee = (float) ($setting->server_security_fee ?? 299.00);

        $totalServerBackupFee = 0.00;
        $totalServerSecurityFee = 0.00;
        $serverBackupCount = 0;
        $serverSecurityCount = 0;
        $hasServerInCart = false;

        foreach ($pendingHostings as $pH) {
            $isServer = false;
            if ($pH->plan && $pH->plan->common_type === \App\Models\Server::class) {
                $isServer = true;
            } else {
                $cText = strtolower(($pH->hosting_name ?? '') . ' ' . ($pH->plan_name ?? ''));
                if (str_contains($cText, 'vps') || str_contains($cText, 'dedicated') || str_contains($cText, 'server plan') || str_contains($cText, 'cloud server')) {
                    $isServer = true;
                }
            }

            if ($isServer) {
                $hasServerInCart = true;
                $hasBackup = session()->has("server_backup_{$pH->id}") 
                    ? session("server_backup_{$pH->id}") 
                    : true;

                $hasSecurity = session()->has("server_security_{$pH->id}") 
                    ? session("server_security_{$pH->id}") 
                    : false;

                if ($hasBackup) {
                    $totalServerBackupFee += $serverBackupFee;
                    $serverBackupCount++;
                }
                if ($hasSecurity) {
                    $totalServerSecurityFee += $serverSecurityFee;
                    $serverSecurityCount++;
                }
            }
        }

        $domainIcannFee = $pendingDomains->count() * 23.00;
        $itemsSubtotal = $pendingDomains->sum('price') + $pendingHostings->sum('price') + $pendingEmails->sum('price');
        $subtotal = $itemsSubtotal + $domainIcannFee + $dailyBackupFee + $domainPrivacyFee + $totalServerBackupFee + $totalServerSecurityFee;
        $discountAmount = 0;
        $coupon = null;

        if (session()->has('coupon')) {
            $coupon = session('coupon');
            if ($coupon['type'] === 'percent') {
                $discountAmount = ($subtotal * $coupon['value']) / 100;
            } else {
                $discountAmount = $coupon['value'];
            }
            $discountAmount = min($discountAmount, $subtotal);
        }

        $taxableAmount = max(0, $subtotal - $discountAmount);
        $gstTax = round($taxableAmount * 0.18, 2);
        $amount = round($taxableAmount + $gstTax, 2);

        $razorpayOrder = $api->order->create([
            'receipt' => 'CART_' . time() . '_' . $userId,
            'amount' => (int) round($amount * 100),
            'currency' => 'INR',
        ]);

        $razorpayOrderId = $razorpayOrder['id'];

        foreach ($pendingDomains as $domain) {
            $domain->update(['razorpay_order_id' => $razorpayOrderId]);
        }
        foreach ($pendingHostings as $hosting) {
            $hosting->update(['razorpay_order_id' => $razorpayOrderId]);
        }
        foreach ($pendingEmails as $email) {
            $email->update(['razorpay_order_id' => $razorpayOrderId]);
        }

        $countries = \App\Models\Country::orderBy('name')->get();

        return view('frontend.cart.cart-checkout', compact(
            'pendingDomains', 
            'pendingHostings', 
            'pendingEmails', 
            'gateway', 
            'razorpayOrder', 
            'subtotal',
            'taxableAmount',
            'gstTax',
            'amount', 
            'discountAmount', 
            'coupon',
            'countries',
            'setting',
            'dailyBackupFee',
            'domainPrivacyFee',
            'serverBackupFee',
            'serverSecurityFee',
            'totalServerBackupFee',
            'totalServerSecurityFee',
            'serverBackupCount',
            'serverSecurityCount',
            'hasServerInCart',
            'backupRemoved',
            'privacyRemoved'
        ));
    }

    public function updateBillingAddress(Request $request)
    {
        $request->validate([
            'first_name'  => 'nullable|string|max:255',
            'last_name'   => 'nullable|string|max:255',
            'email'       => 'nullable|email|max:255',
            'phone'       => 'nullable|string|max:20',
            'company'     => 'nullable|string|max:255',
            'gstin'       => 'nullable|string|max:50',
            'address'     => 'required|string',
            'postal_code' => 'nullable|string|max:20',
            'country_id'  => 'required|exists:countries,id',
            'state_id'    => 'required|exists:states,id',
            'city_id'     => 'required|exists:cities,id',
        ]);

        $user = auth()->user();
        $user->update([
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'company'     => $request->company,
            'gstin'       => $request->gstin,
            'address'     => $request->address,
            'postal_code' => $request->postal_code,
            'country_id'  => $request->country_id,
            'state_id'    => $request->state_id,
            'city_id'     => $request->city_id,
        ]);

        $user->load(['country', 'state', 'city']);

        $fullName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));

        return response()->json([
            'success'     => true,
            'message'     => 'Billing address updated successfully.',
            'first_name'  => $user->first_name ?? '',
            'last_name'   => $user->last_name ?? '',
            'name'        => $fullName,
            'email'       => $user->email ?? '',
            'phone'       => $user->phone ?? '',
            'company'     => $user->company ?? '',
            'gstin'       => $user->gstin ?? '',
            'country'     => $user->country->name ?? '',
            'state'       => $user->state->name ?? '',
            'city'        => $user->city->name ?? '',
            'address'     => $user->address ?? '',
            'postal_code' => $user->postal_code ?? '',
        ]);
    }

    public function updateDomainPeriod(Request $request)
    {
        $order = \App\Models\DomainOrder::where('id', $request->id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $maxYears = 10;
        if (($order->type ?? '') === 'transfer' && !empty($order->expires_at)) {
            try {
                $expDate = \Carbon\Carbon::parse($order->expires_at);
                $remYears = max(0, (int) ceil(now()->floatDiffInYears($expDate, false)));
                $maxYears = max(1, min(10, 10 - $remYears));
            } catch (\Exception $e) {
                $maxYears = 9;
            }
        }

        $request->validate([
            'id' => 'required|exists:domain_orders,id',
            'period' => 'required|integer|min:1|max:' . $maxYears,
        ]);

        // Calculate base (1-year) price
        $basePrice = $order->price / ($order->period ?: 1);
        $newPrice = $basePrice * $request->period;

        $order->update([
            'period' => $request->period,
            'price' => $newPrice,
        ]);

        return response()->json([
            'success' => true,
            'new_price' => number_format($newPrice, 2),
            'message' => 'Period updated successfully.',
        ]);
    }

    public function updateHostingPeriod(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:hosting_orders,id',
            'period' => 'required|integer|in:6,12,24,36,48,60',
        ]);

        $order = \App\Models\HostingOrder::where('id', $request->id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $months = (int) $request->period;

        // Calculate monthly base price from plan or previous period
        $plan = \App\Models\Plan::find($order->plan_id);
        if ($plan && $plan->price > 0) {
            if ($plan->period === 'year') {
                $monthlyBase = (float) $plan->price / 12;
            } else {
                $monthlyBase = (float) $plan->price;
            }
        } else {
            $periodStr = strtolower($order->period ?? '1');
            preg_match('/(\d+)/', $periodStr, $matches);
            $num = !empty($matches[1]) ? (int)$matches[1] : 1;
            $prevMonths = str_contains($periodStr, 'year') ? $num * 12 : (in_array($num, [1, 12, 24, 36, 48, 60]) ? $num : ($num * 12));
            $monthlyBase = (float) $order->price / ($prevMonths ?: 1);
        }

        $newPrice = round($monthlyBase * $months, 2);
        $periodDisplay = $months == 1 ? '1 Month' : ($months . ' Months');

        $order->update([
            'period' => $periodDisplay,
            'price'  => $newPrice,
        ]);

        return response()->json([
            'success'   => true,
            'new_price' => number_format($newPrice, 2),
            'period'    => $periodDisplay,
            'message'   => 'Hosting period updated successfully.',
        ]);
    }

    public function updateEmailPeriod(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:email_orders,id',
            'period' => 'required|integer|in:6,12,24,36,48,60',
        ]);

        $order = \App\Models\EmailOrder::where('id', $request->id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $newMonths = (int) $request->period;

        $periodStr = strtolower($order->period ?? '6');
        preg_match('/(\d+)/', $periodStr, $matches);
        $num = !empty($matches[1]) ? (int)$matches[1] : 6;

        if (str_contains($periodStr, 'year')) {
            $prevMonths = $num * 12;
        } elseif (in_array($num, [1, 2, 3, 4, 5, 6, 12, 24, 36, 48, 60])) {
            $prevMonths = $num;
        } else {
            $prevMonths = 6;
        }

        $monthlyBase = (float) $order->price / ($prevMonths ?: 1);
        $newPrice = round($monthlyBase * $newMonths, 2);

        $periodDisplay = $newMonths . ' Months';

        $order->update([
            'period' => $periodDisplay,
            'price'  => $newPrice,
        ]);

        return response()->json([
            'success'   => true,
            'new_price' => number_format($newPrice, 2),
            'period'    => $periodDisplay,
            'message'   => 'Email period updated successfully.',
        ]);
    }
}
