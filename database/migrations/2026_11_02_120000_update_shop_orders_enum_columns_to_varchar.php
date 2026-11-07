<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            DB::statement("ALTER TABLE shop_orders MODIFY COLUMN payment_mode VARCHAR(100) NOT NULL DEFAULT 'online'");
            DB::statement("ALTER TABLE shop_orders MODIFY COLUMN payment_status VARCHAR(100) NOT NULL DEFAULT 'pending'");
            DB::statement("ALTER TABLE shop_orders MODIFY COLUMN order_status VARCHAR(100) NOT NULL DEFAULT 'processing'");
        } catch (\Throwable $e) {}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement("ALTER TABLE shop_orders MODIFY COLUMN payment_mode ENUM('online','cod') NOT NULL DEFAULT 'online'");
            DB::statement("ALTER TABLE shop_orders MODIFY COLUMN payment_status ENUM('pending','paid','failed') NOT NULL DEFAULT 'pending'");
            DB::statement("ALTER TABLE shop_orders MODIFY COLUMN order_status ENUM('pending','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending'");
        } catch (\Throwable $e) {}
    }
};
