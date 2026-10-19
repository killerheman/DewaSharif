<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (Schema::hasTable('cab_bookings')) {
    Schema::table('cab_bookings', function (Blueprint $table) {
        if (!Schema::hasColumn('cab_bookings', 'customer_email')) {
            $table->string('customer_email')->nullable()->after('customer_phone');
        }
        if (!Schema::hasColumn('cab_bookings', 'customer_address')) {
            $table->text('customer_address')->nullable()->after('customer_email');
        }
    });
    echo "Columns customer_email and customer_address checked/added successfully." . PHP_EOL;
}
