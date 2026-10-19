<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\DataStore;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Users Count (DB + DataStore)
        $dbUsersCount = 0;
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('users')) {
                $dbUsersCount = \App\Models\User::count();
            }
        } catch (\Throwable $e) {}

        $dsUsers = DataStore::getCollection('users');
        $usersCount = max($dbUsersCount, count($dsUsers));

        // 2. Hotels Count (DB + DataStore)
        $dbHotelsCount = 0;
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('hotels')) {
                $dbHotelsCount = \App\Models\Hotel::count();
            }
        } catch (\Throwable $e) {}

        $hotels = DataStore::getCollection('hotels');
        $hotelsCount = max($dbHotelsCount, count($hotels));

        // 3. Cabs Count (DB + DataStore)
        $dbCabsCount = 0;
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('cabs')) {
                $dbCabsCount = \App\Models\Cab::count();
            }
        } catch (\Throwable $e) {}

        $cabs = DataStore::getCollection('cabs');
        $cabsCount = max($dbCabsCount, count($cabs));

        // Bookings Collections
        $hotelBookings = DataStore::getCollection('hotel_bookings');
        $cabBookings = DataStore::getCollection('cab_bookings');
        $shopOrders = DataStore::getCollection('shop_orders');
        $tickets = DataStore::getCollection('tickets');

        // DB Invoices sum
        $dbRevenue = 0;
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('invoices')) {
                $dbRevenue = (float)\App\Models\Invoice::where('payment_status', 'Paid')->sum('net_amount');
            }
        } catch (\Throwable $e) {}

        $hotelRevenue = array_reduce($hotelBookings, function($sum, $b) { return $sum + (float)($b['total_amount'] ?? ($b['amount'] ?? 0)); }, 0);
        $cabRevenue = array_reduce($cabBookings, function($sum, $b) { return $sum + (float)($b['fare'] ?? 0); }, 0);
        $shopRevenue = array_reduce($shopOrders, function($sum, $o) { return $sum + (float)($o['total_amount'] ?? 0); }, 0);

        $totalGmv = $dbRevenue + $hotelRevenue + $cabRevenue + $shopRevenue;
        $formattedRevenue = number_format($totalGmv, 2);

        $stats = [
            'users_count' => $usersCount,
            'hotels_count' => $hotelsCount,
            'cabs_count' => max($cabsCount, count($cabBookings)),
            'tickets_count' => count($tickets),
            'shop_orders_count' => count($shopOrders),
            'total_revenue' => $formattedRevenue,
            'total_gmv' => $totalGmv,
        ];

        return view('admin.dashboard.index', compact('stats', 'hotelBookings', 'cabBookings', 'shopOrders'));
    }

    public function updateServiceStatus(\Illuminate\Http\Request $request)
    {
        $service = trim($request->input('service'));
        $status = trim($request->input('status'));

        if ($service === 'hotels') {
            \App\Models\Setting::setVal('service_hotels_status', $status, 'services');
            $label = 'Hotels & Guest Houses Portal';
        } elseif ($service === 'cabs') {
            \App\Models\Setting::setVal('service_cabs_status', $status, 'services');
            $label = 'Auto & Cab Booking Portal';
        } elseif ($service === 'shop') {
            \App\Models\Setting::setVal('service_shop_status', $status, 'services');
            $label = 'Sacred Online Shop';
        } else {
            return redirect()->back()->with('error', 'Invalid service specified.');
        }

        $statusHuman = strtoupper(str_replace('_', ' ', $status));
        return redirect()->back()->with('success', "{$label} is now set to: {$statusHuman}");
    }
}
