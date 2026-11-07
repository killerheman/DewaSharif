<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasColumn('shop_orders', 'packaging_type')) {
    Schema::table('shop_orders', function (Blueprint $table) {
        $table->string('packaging_type', 100)->nullable()->after('packaging_fee');
    });
    echo "Column 'packaging_type' added successfully to shop_orders.\n";
} else {
    echo "Column 'packaging_type' already exists in shop_orders.\n";
}
