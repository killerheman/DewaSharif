<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\DataStore;

class CustomerAdminController extends Controller
{
    public function index()
    {
        $hotelBookings = DataStore::getCollection('hotel_bookings');
        $cabBookings = DataStore::getCollection('cab_bookings');
        $shopOrders = DataStore::getCollection('shop_orders');

        $customers = [
            [
                'id' => '1001',
                'name' => 'Mohd Amir Khan',
                'phone' => '+91 9876543210',
                'email' => 'amir.khan@gmail.com',
                'city' => 'Lucknow, UP',
                'bookings_count' => '3 Stays & Cabs',
                'status' => 'Active Pilgrim'
            ],
            [
                'id' => '1002',
                'name' => 'Syed Rashid Warsi',
                'phone' => '+91 9123456789',
                'email' => 'rashid.warsi@gmail.com',
                'city' => 'Mumbai, MH',
                'bookings_count' => '5 Orders & Stays',
                'status' => 'VIP Pilgrim'
            ],
            [
                'id' => '1003',
                'name' => 'Tariq Ansari',
                'phone' => '+91 9988776655',
                'email' => 'tariq.ansari@gmail.com',
                'city' => 'Kanpur, UP',
                'bookings_count' => '2 Cabs',
                'status' => 'Active Pilgrim'
            ]
        ];

        return view('admin.customers.index', compact('customers'));
    }
}
