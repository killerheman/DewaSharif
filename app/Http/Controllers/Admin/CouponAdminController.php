<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\DataStore;
use Illuminate\Http\Request;

class CouponAdminController extends Controller
{
    public function index()
    {
        $coupons = DataStore::getCollection('coupons');
        if (empty($coupons)) {
            // Seed initial sample coupons if empty
            DataStore::addItem('coupons', [
                'code' => 'DEWA50',
                'type' => 'percent',
                'value' => 50,
                'description' => '50% Discount on First Hotel Booking',
                'status' => 'Active'
            ]);
            DataStore::addItem('coupons', [
                'code' => 'CAB100',
                'type' => 'fixed',
                'value' => 100,
                'description' => 'Flat ₹100 Off on Cab Duty Bookings',
                'status' => 'Active'
            ]);
            $coupons = DataStore::getCollection('coupons');
        }
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $code = strtoupper(trim($request->input('code', '')));
        $type = $request->input('type', 'percent');
        $value = (float)$request->input('value', 10);
        $desc = $request->input('description', '');

        if (!$code) {
            return back()->with('error', 'Coupon Code is required!');
        }

        DataStore::addItem('coupons', [
            'code' => $code,
            'type' => $type,
            'value' => $value,
            'description' => $desc ?: ($type === 'percent' || $type === 'percentage' ? "{$value}% Discount Coupon" : "Flat ₹{$value} Off Coupon"),
            'status' => 'Active'
        ]);

        return redirect()->route('admin.coupons.index')->with('success', "Coupon Code '{$code}' created & activated successfully!");
    }

    public function edit($id)
    {
        $coupons = DataStore::getCollection('coupons');
        $coupon = null;
        foreach ($coupons as $c) {
            if ((is_array($c) ? ($c['id'] ?? null) : $c->id) == $id) {
                $coupon = (object)(is_array($c) ? $c : (array)$c);
                break;
            }
        }

        if (!$coupon) {
            $coupon = (object)[
                'id' => $id,
                'code' => 'DEWA50',
                'type' => 'percent',
                'value' => 50,
                'description' => '50% Discount Coupon',
                'is_active' => true,
                'expiry_date' => null
            ];
        }

        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $code = strtoupper(trim($request->input('code', '')));
        $type = $request->input('type', 'percent');
        $value = (float)$request->input('value', 10);

        DataStore::updateItem('coupons', $id, [
            'code' => $code,
            'type' => $type,
            'value' => $value,
            'description' => $type === 'percent' ? "{$value}% Discount Coupon" : "Flat ₹{$value} Off Coupon",
            'status' => $request->has('is_active') ? 'Active' : 'Inactive'
        ]);

        return redirect()->route('admin.coupons.index')->with('success', "Coupon '{$code}' updated successfully!");
    }

    public function destroy($id)
    {
        DataStore::deleteItem('coupons', $id);
        return back()->with('success', "Coupon deleted successfully!");
    }
}

