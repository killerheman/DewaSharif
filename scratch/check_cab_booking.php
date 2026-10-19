<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DB cab_bookings ===" . PHP_EOL;
try {
    $rows = \Illuminate\Support\Facades\DB::table('cab_bookings')->get();
    foreach ($rows as $r) {
        echo "ID: " . ($r->id ?? '') . " | Code: " . ($r->booking_code ?? '') . " | VType: [" . ($r->vehicle_type ?? '') . "] | VName: [" . ($r->vehicle_name ?? '') . "] | VPlate: [" . ($r->driver_vehicle_number ?? '') . "] | Driver: [" . ($r->driver_name ?? '') . "]" . PHP_EOL;
    }
} catch (\Throwable $e) {
    echo "DB error: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . "=== DataStore cab_bookings ===" . PHP_EOL;
$ds = \App\Helpers\DataStore::getCollection('cab_bookings');
foreach ($ds as $c) {
    echo "ID: " . ($c['id'] ?? '') . " | Code: " . ($c['booking_code'] ?? '') . " | Name: " . ($c['customer_name'] ?? '') . " | Fare: " . ($c['fare'] ?? $c['total_fare'] ?? '') . " | PayStatus: " . ($c['payment_status'] ?? '') . " | Status: " . ($c['status'] ?? '') . PHP_EOL;
}
