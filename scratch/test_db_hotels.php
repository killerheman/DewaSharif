<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$dbHotels = DB::table('hotels')->orderBy('id', 'asc')->get();
echo "Total hotels from DB: " . $dbHotels->count() . PHP_EOL;
$first = (array)$dbHotels->first();
echo "First hotel name: " . $first['name'] . PHP_EOL;
echo "First hotel price: " . $first['price_per_night'] . PHP_EOL;
echo "First hotel room type: " . $first['room_type'] . PHP_EOL;
