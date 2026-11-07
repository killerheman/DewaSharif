<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$hasDistFee = Schema::hasColumn('shop_orders', 'distribution_fee');
echo "Has distribution_fee column: " . ($hasDistFee ? "YES" : "NO") . "\n";

if (!$hasDistFee) {
    DB::statement("ALTER TABLE `shop_orders` ADD COLUMN `distribution_fee` DECIMAL(10,2) DEFAULT 0.00 AFTER `packaging_fee`");
    echo "Added column distribution_fee to shop_orders table successfully.\n";
} else {
    echo "Column distribution_fee already exists.\n";
}
