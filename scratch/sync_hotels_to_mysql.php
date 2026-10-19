<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Helpers\DataStore;
use Illuminate\Support\Facades\DB;

echo "=== SYNCING HOTELS TO MYSQL ===" . PHP_EOL;

$hotels = DataStore::getCollection('hotels');
echo "Found " . count($hotels) . " hotels in DataStore." . PHP_EOL;

foreach ($hotels as $h) {
    $amenities = $h['amenities'] ?? [];
    if (is_array($amenities)) {
        $amenitiesStr = json_encode($amenities);
    } else {
        $amenitiesStr = (string)$amenities;
    }

    DB::table('hotels')->updateOrInsert(
        ['id' => $h['id']],
        [
            'id' => $h['id'],
            'name' => $h['name'] ?? 'Hotel Room',
            'slug' => \Illuminate\Support\Str::slug($h['name'] ?? 'hotel') . '-' . $h['id'],
            'address' => $h['location'] ?? ($h['distance'] ?? 'Near Dewa Sharif Dargah'),
            'location' => $h['location'] ?? ($h['distance'] ?? 'Near Dewa Sharif Dargah'),
            'distance' => $h['distance'] ?? ($h['location'] ?? 'Near Dargah Gate'),
            'phone' => $h['phone'] ?? '+91 9648777223',
            'description' => $h['description'] ?? ($h['room_type'] ?? 'Deluxe Room'),
            'cover_image' => $h['image'] ?? asset('home/images/dewasharif/dewapage/hero_hotel_bg.jpg'),
            'image' => $h['image'] ?? asset('home/images/dewasharif/dewapage/hero_hotel_bg.jpg'),
            'image_main' => $h['image_main'] ?? ($h['image'] ?? asset('home/images/dewasharif/dewapage/hero_hotel_bg.jpg')),
            'image_reception' => $h['image_reception'] ?? asset('home/images/dewasharif/dewapage/hero_hotel_bg.jpg'),
            'image_room' => $h['image_room'] ?? asset('home/images/dewasharif/dewapage/deluxe_room.jpg'),
            'image_bathroom' => $h['image_bathroom'] ?? asset('home/images/dewasharif/dewapage/standard_room.jpg'),
            'image_extra' => $h['image_extra'] ?? asset('home/images/dewasharif/dewapage/deluxe_room.jpg'),
            'price' => (float)($h['price'] ?? ($h['price_per_night'] ?? 1499)),
            'price_per_night' => (float)($h['price_per_night'] ?? ($h['price'] ?? 1499)),
            'mrp' => (float)($h['mrp'] ?? 1999),
            'available_rooms' => (int)($h['available_rooms'] ?? 10),
            'category' => $h['category'] ?? 'queen_ac',
            'category_name' => $h['category_name'] ?? ($h['room_type'] ?? 'Queen Size AC'),
            'room_type' => $h['room_type'] ?? ($h['category_name'] ?? 'Deluxe AC Room'),
            'ac_type' => $h['ac_type'] ?? 'AC',
            'bed_type' => $h['bed_type'] ?? 'Double Bed',
            'max_adults' => (int)($h['max_adults'] ?? 2),
            'max_children' => (int)($h['max_children'] ?? 1),
            'bath_type' => $h['bath_type'] ?? 'Attached Western Bath',
            'amenities' => $amenitiesStr,
            'status' => strtolower($h['status'] ?? 'active') === 'active' ? 'active' : 'inactive',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]
    );
    echo "Synced Hotel #{$h['id']}: {$h['name']}" . PHP_EOL;
}

echo "=== SYNCING HOTEL BOOKINGS TO MYSQL ===" . PHP_EOL;
$bookings = DataStore::getCollection('hotel_bookings');
echo "Found " . count($bookings) . " bookings in DataStore." . PHP_EOL;

foreach ($bookings as $b) {
    $bCode = $b['booking_code'] ?? ($b['booking_number'] ?? ('DWS-HTL-' . date('Y') . '-' . rand(1000, 9999)));
    $totAmt = (float)($b['total_amount'] ?? ($b['amount'] ?? ($b['price'] ?? ($b['total_fare'] ?? 1499))));
    $status = $b['status'] ?? 'Confirmed & Paid';

    $rawCheckin = $b['checkin'] ?? ($b['check_in'] ?? date('Y-m-d'));
    $checkinVal = date('Y-m-d', strtotime($rawCheckin) ?: time());

    $rawCheckout = $b['checkout'] ?? ($b['check_out'] ?? date('Y-m-d', strtotime('+1 day')));
    $checkoutVal = date('Y-m-d', strtotime($rawCheckout) ?: strtotime('+1 day'));

    DB::table('hotel_bookings')->updateOrInsert(
        ['booking_id' => $bCode],
        [
            'booking_id' => $bCode,
            'booking_code' => $bCode,
            'booking_number' => $bCode,
            'hotel_id' => 1,
            'hotel_name' => $b['hotel_name'] ?? 'Al-Waris Deluxe Guest House',
            'room_name' => $b['room_name'] ?? 'Deluxe AC Double Room',
            'customer_name' => $b['customer_name'] ?? ($b['name'] ?? 'Guest User'),
            'customer_phone' => $b['customer_phone'] ?? ($b['phone'] ?? '9648777223'),
            'check_in' => $checkinVal,
            'check_out' => $checkoutVal,
            'persons' => (int)($b['guests'] ?? ($b['persons'] ?? 2)),
            'rooms' => (int)($b['rooms'] ?? 1),
            'nights' => (int)($b['nights'] ?? 1),
            'total_amount' => $totAmt,
            'paid_amount' => $totAmt,
            'pending_amount' => 0.00,
            'price_per_night' => (float)($b['price_per_night'] ?? $totAmt),
            'id_type' => $b['id_type'] ?? 'Aadhaar Card',
            'id_no' => $b['id_no'] ?? 'N/A',
            'payment_id' => $b['payment_id'] ?? ('RZP_HOTEL_' . time()),
            'payment_mode' => 'full',
            'payment_status' => 'paid',
            'hotel_status' => 'confirmed',
            'booking_status' => 'confirmed',
            'status' => $status,
            'settlement_status' => 'pending',
            'created_at' => date('Y-m-d H:i:s', strtotime($b['created_at'] ?? 'now') ?: time()),
            'updated_at' => date('Y-m-d H:i:s'),
        ]
    );
    echo "Synced Booking {$bCode}" . PHP_EOL;
}

echo "=== VERIFY DATABASE COUNTS ===" . PHP_EOL;
echo "DB hotels count: " . DB::table('hotels')->count() . PHP_EOL;
echo "DB hotel_bookings count: " . DB::table('hotel_bookings')->count() . PHP_EOL;
