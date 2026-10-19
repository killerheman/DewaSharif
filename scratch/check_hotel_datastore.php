<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Helpers\DataStore;

$hotels = DataStore::getCollection('hotels');
echo "DataStore hotels count: " . count($hotels) . PHP_EOL;
echo "Sample hotel 1:" . PHP_EOL;
print_r($hotels[0] ?? null);

$bookings = DataStore::getCollection('hotel_bookings');
echo "DataStore hotel_bookings count: " . count($bookings) . PHP_EOL;
echo "Sample booking 1:" . PHP_EOL;
print_r($bookings[0] ?? null);
