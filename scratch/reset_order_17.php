<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

DB::table('shop_orders')->where('id', 17)->update([
    'items_summary' => 'Special Warsi Chicken Biryani Degh (10 Kg Chicken + 10 Kg Rice)',
    'packaging_fee' => 0.00,
    'packaging_type' => 'none',
    'total_amount' => 4707.00,
    'paid_amount' => 3707.00,
    'payment_status' => 'pending'
]);

echo "Order 17 reset cleanly to pending advance test state.\n";
