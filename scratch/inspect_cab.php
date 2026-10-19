<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Helpers\DataStore;

echo "=== 1. MYSQL TABLES FOR CAB ===" . PHP_EOL;
$cabTables = DB::select('SHOW TABLES LIKE "%cab%"');
print_r($cabTables);

foreach (['cabs', 'cab_bookings', 'cab_routes'] as $tbl) {
    try {
        echo "=== DESCRIBE $tbl ===" . PHP_EOL;
        $cols = DB::select("DESCRIBE $tbl");
        foreach ($cols as $c) {
            echo "{$c->Field} ({$c->Type}) Null:{$c->Null} Default:{$c->Default}" . PHP_EOL;
        }
        echo "Total rows in $tbl: " . DB::table($tbl)->count() . PHP_EOL;
    } catch (\Throwable $e) {
        echo "Error on $tbl: " . $e->getMessage() . PHP_EOL;
    }
}

echo PHP_EOL . "=== 2. DATASTORE CABS & BOOKINGS ===" . PHP_EOL;
$dsCabs = DataStore::getCollection('cabs');
echo "DataStore cabs count: " . count($dsCabs) . PHP_EOL;
echo "Sample cab 1:" . PHP_EOL;
print_r($dsCabs[0] ?? null);

$dsCabBookings = DataStore::getCollection('cab_bookings');
echo "DataStore cab_bookings count: " . count($dsCabBookings) . PHP_EOL;
echo "Sample cab_booking 1:" . PHP_EOL;
print_r($dsCabBookings[0] ?? null);
