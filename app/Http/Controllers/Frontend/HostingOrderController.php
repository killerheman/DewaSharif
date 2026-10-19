<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Hosting;
use App\Models\HostingOrder;
use App\Models\PaymentSetting;
use App\Models\Plan;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Razorpay\Api\Api;

class HostingOrderController extends Controller
{
    /**
     * Create a hosting order and redirect to checkout.
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $hostingId = $request->hosting_id ?? $plan->common_id;
        $hostingName = 'Hosting Plan';

        if ($request->hosting_id) {
            $hostingObj = Hosting::find($request->hosting_id) ?? Server::find($request->hosting_id);
            if ($hostingObj) {
                $hostingName = $hostingObj->name;
            }
        } elseif ($plan->common_type && class_exists($plan->common_type)) {
            $related = $plan->common_type::find($plan->common_id);
            if ($related) {
                $hostingName = $related->name;
            }
        }

        if (!auth()->check()) {
            session(['pending_plan_id' => $plan->id, 'pending_hosting_id' => $hostingId]);
            return redirect()->route('login')->with('info', 'Please login to add this plan to your cart.');
        }

        // Check duplicate
        $exists = HostingOrder::where('user_id', auth()->id())
            ->where('plan_id', $plan->id)
            ->where('status', 'pending')
            ->exists();
        if ($exists) {
            return redirect()->route('cart')->with('info', 'This plan is already in your cart!');
        }

        try {
            $initialPeriod = ($plan->period === 'year') ? '12 Months' : '6 Months';

            // Create a pending hosting order in DB
            $hostingOrder = HostingOrder::create([
                'user_id'          => auth()->id(),
                'hosting_id'       => $hostingId,
                'plan_id'          => $plan->id,
                'plan_name'        => $plan->name,
                'hosting_name'     => $hostingName,
                'price'            => $plan->price,
                'period'           => $initialPeriod,
                'razorpay_order_id'=> null,
                'status'           => 'pending',
            ]);

            return redirect()->route('cart')->with('success', 'Plan added to cart successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Could not add to cart: ' . $e->getMessage());
        }
    }

    public function checkout($id)
    {
        $hostingOrder = HostingOrder::findOrFail($id);

        if ($hostingOrder->user_id !== auth()->id()) {
            abort(403);
        }

        $gateway = PaymentSetting::where('gateway', 'Razorpay')->where('is_active', true)->first();

        $api = new Api($gateway->key_id, $gateway->key_secret);

        $basePrice = (float) $hostingOrder->price;
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
            'receipt'  => 'HOSTING_' . $hostingOrder->id,
            'amount'   => (int) round($totalAmount * 100), // paise
            'currency' => $gateway->currency ?? 'INR',
        ]);

        $hostingOrder->update(['razorpay_order_id' => $razorpayOrder['id']]);

        return view('frontend.hosting.checkout', [
            'order'          => $hostingOrder,
            'basePrice'      => $basePrice,
            'discountAmount' => $discountAmount,
            'taxableAmount'  => $taxableAmount,
            'gstTax'         => $gstTax,
            'totalAmount'    => $totalAmount,
            'coupon'         => $coupon,
            'razorpayOrder'  => $razorpayOrder,
            'gateway'        => $gateway,
        ]);
    }
}
