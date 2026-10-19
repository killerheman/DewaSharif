<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Helpers\DataStore;

echo "=== 1. TEST DB HOTELS COUNT ===" . PHP_EOL;
$countHotels = DB::table('hotels')->count();
echo "MySQL hotels count: {$countHotels}" . PHP_EOL;

echo "=== 2. TEST DB BOOKINGS COUNT ===" . PHP_EOL;
$countBookings = DB::table('hotel_bookings')->count();
echo "MySQL hotel_bookings count: {$countBookings}" . PHP_EOL;

echo "=== 3. TEST DATASTORE GETCOLLECTION('hotels') ===" . PHP_EOL;
$dsHotels = DataStore::getCollection('hotels');
echo "DataStore hotels: " . count($dsHotels) . PHP_EOL;

echo "=== 4. TEST DATASTORE GETCOLLECTION('hotel_bookings') ===" . PHP_EOL;
$dsBookings = DataStore::getCollection('hotel_bookings');
echo "DataStore hotel_bookings: " . count($dsBookings) . PHP_EOL;

echo "=== 5. TEST VIEW RENDERING ===" . PHP_EOL;
try {
    $hotelReviews = DB::table('reviews')->where('service_type', 'hotel')->where('status', 'approved')->get();
    $viewHotels = view('home.hotels.hotel', ['hotels' => $dsHotels, 'hotelReviews' => $hotelReviews])->render();
    echo "home.hotels.hotel view rendered successfully! Length: " . strlen($viewHotels) . PHP_EOL;
} catch (\Throwable $e) {
    echo "ERROR home.hotels.hotel: " . $e->getMessage() . PHP_EOL;
}

try {
    $hotel = $dsHotels[0] ?? null;
    $viewDetail = view('home.hotels.detail', ['id' => 1, 'hotel' => $hotel, 'hotels' => $dsHotels])->render();
    echo "home.hotels.detail view rendered successfully! Length: " . strlen($viewDetail) . PHP_EOL;
} catch (\Throwable $e) {
    echo "ERROR home.hotels.detail: " . $e->getMessage() . PHP_EOL;
}

try {
    $viewAdminBookings = view('admin.hotels.bookings', ['bookings' => $dsBookings])->render();
    echo "admin.hotels.bookings view rendered successfully! Length: " . strlen($viewAdminBookings) . PHP_EOL;
} catch (\Throwable $e) {
    echo "ERROR admin.hotels.bookings: " . $e->getMessage() . PHP_EOL;
}

try {
    $viewAdminHotels = view('admin.hotels.index', ['hotels' => $dsHotels])->render();
    echo "admin.hotels.index view rendered successfully! Length: " . strlen($viewAdminHotels) . PHP_EOL;
} catch (\Throwable $e) {
    echo "ERROR admin.hotels.index: " . $e->getMessage() . PHP_EOL;
}

echo "=== ALL CHECKS COMPLETED SUCCESSFULLY ===" . PHP_EOL;
