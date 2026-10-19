<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$cols = \Illuminate\Support\Facades\Schema::getColumnListing('hotel_bookings');
echo "Columns in hotel_bookings: " . implode(', ', $cols) . PHP_EOL;
