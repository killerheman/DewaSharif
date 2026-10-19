<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\EmailOrder;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Exception;
use Illuminate\Support\Facades\Log;

class EmailOrderController extends Controller
{
    public function createOrder(Request $request)
    {
        if ($request->has('plan_id') && $request->plan_id) {
            $plan = \App\Models\Plan::find($request->plan_id);
            if ($plan) {
                $request->merge([
                    'plan_name' => $request->plan_name ?? $plan->name,
                    'price'     => $request->price ?? $plan->price,
                    'period'    => $request->period ?? $plan->period ?? '6 Months',
                ]);
            }
        }

        if (!$request->has('domain_name') || empty($request->domain_name)) {
            $request->merge(['domain_name' => 'mybusiness.com']);
        }
        if (!$request->has('desired_email') || empty($request->desired_email)) {
            $request->merge(['desired_email' => 'info']);
        }

        $request->validate([
            'plan_name'     => 'required|string',
            'provider'      => 'required|string',
            'domain_name'   => 'required|string',
            'desired_email' => 'required|string',
            'price'         => 'required|numeric',
            'period'        => 'required|string'
        ]);

        $rawPrice = (float) $request->price;
        $rawPeriod = strtolower($request->period ?? '6');
        $isYear = str_contains($rawPeriod, 'year');

        $monthlyBase = $isYear ? ($rawPrice / 12) : $rawPrice;
        $numMonths = $isYear ? 12 : 6;
        $initialPeriod = $numMonths . ' Months';
        $initialPrice = round($monthlyBase * $numMonths, 2);

        if (!auth()->check()) {
            session([
                'pending_email_order' => [
                    'plan_name'     => $request->plan_name,
                    'provider'      => $request->provider,
                    'domain_name'   => $request->domain_name,
                    'desired_email' => $request->desired_email,
                    'price'         => $initialPrice,
                    'period'        => $initialPeriod,
                ]
            ]);
            return redirect()->route('login')->with('info', 'Please login to add this email plan to your cart.');
        }

        try {
            // Check duplicate pending order for exact same provider & plan
            $exists = EmailOrder::where('user_id', auth()->id())
                ->where('provider', $request->provider)
                ->where('plan_name', $request->plan_name)
                ->where('status', 'pending')
                ->exists();

            if ($exists) {
                return redirect()->route('cart')->with('info', 'This email plan is already in your cart!');
            }

            $order = EmailOrder::create([
                'user_id'           => auth()->id(),
                'plan_name'         => $request->plan_name,
                'provider'          => $request->provider,
                'domain_name'       => $request->domain_name,
                'desired_email'     => $request->desired_email,
                'price'             => $initialPrice,
                'period'            => $initialPeriod,
                'razorpay_order_id' => null, // Will be set during unified checkout
                'status'            => 'pending'
            ]);

            return redirect()->route('cart')->with('success', 'Email plan added to cart successfully!');

        } catch (Exception $e) {
            Log::error('Email Order Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to add to cart: ' . $e->getMessage());
        }
    }

    public function checkout($id)
    {
        $order = EmailOrder::findOrFail($id);

        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $gateway = \App\Models\PaymentSetting::first();

        $api = new Api($gateway->key_id, $gateway->key_secret);

        $basePrice = (float) $order->price;
        $discountAmount = 0;
        $coupon = null;

        if (session()->has('coupon')) {
            $coupon = session('coupon');
            if ($coupon['type'] === 'percent') {
                $discountAmount = ($basePrice * $coupon['value']) / 100;
            } else {
                $discountAmount = $coupon['value'];
            }
            $discountAmount = min($discountAmount, $basePrice);
        }

        $taxableAmount = max(0, $basePrice - $discountAmount);
        $gstTax = round($taxableAmount * 0.18, 2);
        $totalAmount = round($taxableAmount + $gstTax, 2);

        $razorpayOrder = $api->order->create([
            'receipt'         => 'email_order_' . $order->id,
            'amount'          => (int) round($totalAmount * 100),
            'currency'        => 'INR',
            'payment_capture' => 1
        ]);

        $order->update(['razorpay_order_id' => $razorpayOrder['id']]);

        return view('frontend.email.checkout', compact('order', 'basePrice', 'discountAmount', 'taxableAmount', 'gstTax', 'totalAmount', 'coupon', 'razorpayOrder', 'gateway'));
    }
}
