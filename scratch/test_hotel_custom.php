<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$dbRow = \Illuminate\Support\Facades\DB::table('hotel_bookings')
    ->where('booking_code', 'LIKE', 'DWS-HTL-GRP%')
    ->orderBy('created_at', 'desc')
    ->first();

echo "MYSQL DB ROW: " . json_encode($dbRow) . PHP_EOL;
