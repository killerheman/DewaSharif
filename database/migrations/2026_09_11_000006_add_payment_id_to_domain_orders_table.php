<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('domain_orders') && !Schema::hasColumn('domain_orders', 'payment_id')) {
            Schema::table('domain_orders', function (Blueprint $table) {
                $table->string('payment_id')->nullable()->after('razorpay_order_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('domain_orders') && Schema::hasColumn('domain_orders', 'payment_id')) {
            Schema::table('domain_orders', function (Blueprint $table) {
                $table->dropColumn('payment_id');
            });
        }
    }
};
