<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = DB::select('SHOW TABLES LIKE "%hotel%"');
echo "=== HOTEL TABLES ===" . PHP_EOL;
print_r($tables);

foreach (['hotels', 'hotel_bookings'] as $table) {
    echo "=== DESCRIBE $table ===" . PHP_EOL;
    try {
        $cols = DB::select("DESCRIBE $table");
        foreach ($cols as $col) {
            echo "{$col->Field} ({$col->Type}) Null:{$col->Null} Default:{$col->Default}" . PHP_EOL;
        }
    } catch (\Exception $e) {
        echo "Error describing $table: " . $e->getMessage() . PHP_EOL;
    }
}

echo "=== HOTELS COUNT ===" . PHP_EOL;
echo "DB hotels: " . DB::table('hotels')->count() . PHP_EOL;
echo "DB hotel_bookings: " . DB::table('hotel_bookings')->count() . PHP_EOL;
