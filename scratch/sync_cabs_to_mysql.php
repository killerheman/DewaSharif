<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Helpers\DataStore;
use Illuminate\Support\Facades\DB;

echo "=== 1. SYNCING CABS TO MYSQL ===" . PHP_EOL;
$cabs = DataStore::getCollection('cabs');
echo "Found " . count($cabs) . " cabs in DataStore." . PHP_EOL;

foreach ($cabs as $c) {
    $fare = (float)($c['fare'] ?? ($c['price'] ?? 1400));
    DB::table('cabs')->updateOrInsert(
        ['id' => $c['id']],
        [
            'id' => $c['id'],
            'vehicle_name' => $c['vehicle_name'] ?? 'Swift Dzire',
            'vehicle_number' => $c['vehicle_number'] ?? 'UP 32 AB 1234',
            'vehicle_type' => $c['vehicle_type'] ?? ($c['title'] ?? 'Sedan'),
            'ac_option' => $c['ac_option'] ?? 'AC',
            'seating_capacity' => $c['seating_capacity'] ?? ($c['capacity'] ?? '4 Passengers + 1 Driver'),
            'capacity' => $c['capacity'] ?? ($c['seating_capacity'] ?? '4 Passengers + 1 Driver'),
            'toll_status' => $c['toll_status'] ?? 'Toll Tax Included',
            'title' => $c['title'] ?? ($c['vehicle_type'] ?? 'Sedan'),
            'route_name' => $c['route_name'] ?? ($c['route'] ?? 'Lucknow ↔ Dewa Sharif'),
            'route' => $c['route'] ?? ($c['route_name'] ?? 'Lucknow ↔ Dewa Sharif'),
            'pickup' => $c['pickup'] ?? 'Dewa Sharif',
            'destination' => $c['destination'] ?? 'Lucknow Charbagh Railway Station',
            'fare' => $fare,
            'price' => $fare,
            'driver_name' => $c['driver_name'] ?? 'Ramesh Kumar',
            'driver_phone' => $c['driver_phone'] ?? '+91 9648777223',
            'driver_aadhaar' => $c['driver_aadhaar'] ?? '1234 5678 9012',
            'driver_dl' => $c['driver_dl'] ?? 'UP32-2022-0089123',
            'luggage_capacity' => $c['luggage_capacity'] ?? '2 Large Bags + 2 Small Bags',
            'image' => $c['image'] ?? asset('home/images/dewasharif/dewapage/cab_dzire.jpg'),
            'status' => strtolower($c['status'] ?? 'active') === 'active' ? 'active' : 'inactive',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]
    );
    echo "Synced Cab #{$c['id']}: {$c['vehicle_name']} ({$c['route_name']})" . PHP_EOL;
}

echo PHP_EOL . "=== 2. SYNCING CAB BOOKINGS TO MYSQL ===" . PHP_EOL;
$cabBookings = DataStore::getCollection('cab_bookings');
echo "Found " . count($cabBookings) . " cab_bookings in DataStore." . PHP_EOL;

foreach ($cabBookings as $b) {
    $bCode = $b['booking_code'] ?? ($b['booking_number'] ?? ('DWS-CAB-' . date('Y') . '-' . rand(1000, 9999)));
    $fare = (float)($b['fare'] ?? ($b['total_fare'] ?? ($b['total_amount'] ?? 1400)));
    $status = $b['status'] ?? 'Confirmed & Paid';
    $rawStatus = strtolower($status);
    $payStatus = (str_contains($rawStatus, 'paid') || str_contains($rawStatus, 'confirm')) ? 'paid' : 'pending';
    $bookStatus = (str_contains($rawStatus, 'paid') || str_contains($rawStatus, 'confirm')) ? 'assigned' : 'pending';

    $rawDate = $b['pickup_date'] ?? date('Y-m-d');
    $pickupDate = date('Y-m-d', strtotime($rawDate) ?: time());

    DB::table('cab_bookings')->updateOrInsert(
        ['booking_id' => $bCode],
        [
            'booking_id' => $bCode,
            'booking_code' => $bCode,
            'cab_id' => 1,
            'customer_name' => $b['customer_name'] ?? 'Passenger',
            'customer_phone' => $b['customer_phone'] ?? '9648777223',
            'pickup_location' => $b['pickup'] ?? ($b['pickup_location'] ?? 'Dewa Sharif'),
            'drop_location' => $b['destination'] ?? ($b['drop_location'] ?? 'Lucknow Charbagh Railway Station'),
            'route' => $b['route'] ?? (($b['pickup'] ?? 'Dewa Sharif') . ' → ' . ($b['destination'] ?? 'Lucknow')),
            'pickup_date' => $pickupDate,
            'pickup_time' => $b['pickup_time'] ?? date('Y-m-d @ H:i'),
            'vehicle_type' => $b['vehicle_type'] ?? 'Sedan',
            'vehicle_name' => $b['vehicle_name'] ?? ($b['vehicle_type'] ?? 'Swift Dzire'),
            'total_amount' => $fare,
            'fare' => $fare,
            'total_fare' => $fare,
            'paid_amount' => $fare,
            'pending_amount' => 0.00,
            'night_surcharge' => (float)($b['night_surcharge'] ?? 0),
            'id_type' => $b['id_type'] ?? 'Aadhaar Card',
            'id_no' => $b['id_no'] ?? 'N/A',
            'driver' => $b['driver'] ?? 'Assigned Duty Driver',
            'driver_name' => $b['driver_name'] ?? 'Ramesh Kumar',
            'driver_phone' => $b['driver_phone'] ?? '9648777223',
            'driver_vehicle_number' => $b['driver_vehicle_number'] ?? 'UP 32 AB 1234',
            'payment_mode' => 'full',
            'payment_status' => $payStatus,
            'booking_status' => $bookStatus,
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s', strtotime($b['created_at'] ?? 'now') ?: time()),
            'updated_at' => date('Y-m-d H:i:s'),
        ]
    );
    echo "Synced Cab Booking {$bCode}" . PHP_EOL;
}

echo PHP_EOL . "=== 3. SYNCING CAB VEHICLES & LOCATIONS ===" . PHP_EOL;
$vehicles = DataStore::getCollection('cab_vehicles');
foreach ($vehicles as $v) {
    DB::table('cab_vehicles')->updateOrInsert(
        ['id' => $v['id']],
        [
            'id' => $v['id'],
            'name' => $v['name'] ?? 'Swift Dzire',
            'type' => $v['type'] ?? 'Standard Taxi',
            'capacity' => $v['capacity'] ?? '4 Passengers + 1 Driver',
            'price' => (float)($v['price'] ?? 1400),
            'fare' => (float)($v['fare'] ?? ($v['price'] ?? 1400)),
            'fare_factor' => (float)($v['fare_factor'] ?? 1.00),
            'status' => $v['status'] ?? 'Active',
            'image' => $v['image'] ?? asset('home/images/dewasharif/dewapage/cab_dzire.jpg'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]
    );
}
echo "Synced " . count($vehicles) . " cab_vehicles into MySQL." . PHP_EOL;

$locations = DataStore::getCollection('cab_locations');
foreach ($locations as $l) {
    DB::table('cab_locations')->updateOrInsert(
        ['id' => $l['id']],
        [
            'id' => $l['id'],
            'name' => $l['name'] ?? 'Location',
            'type' => $l['type'] ?? 'Both',
            'status' => $l['status'] ?? 'Active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]
    );
}
echo "Synced " . count($locations) . " cab_locations into MySQL." . PHP_EOL;

echo PHP_EOL . "=== VERIFY DATABASE COUNTS ===" . PHP_EOL;
echo "DB cabs count: " . DB::table('cabs')->count() . PHP_EOL;
echo "DB cab_bookings count: " . DB::table('cab_bookings')->count() . PHP_EOL;
echo "DB cab_vehicles count: " . DB::table('cab_vehicles')->count() . PHP_EOL;
echo "DB cab_locations count: " . DB::table('cab_locations')->count() . PHP_EOL;
