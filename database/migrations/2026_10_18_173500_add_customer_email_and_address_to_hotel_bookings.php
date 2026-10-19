<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('hotel_bookings')) {
            Schema::table('hotel_bookings', function (Blueprint $table) {
                if (!Schema::hasColumn('hotel_bookings', 'customer_email')) {
                    $table->string('customer_email')->nullable()->after('customer_phone');
                }
                if (!Schema::hasColumn('hotel_bookings', 'customer_address')) {
                    $table->text('customer_address')->nullable()->after('customer_email');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('hotel_bookings')) {
            Schema::table('hotel_bookings', function (Blueprint $table) {
                if (Schema::hasColumn('hotel_bookings', 'customer_address')) {
                    $table->dropColumn('customer_address');
                }
                if (Schema::hasColumn('hotel_bookings', 'customer_email')) {
                    $table->dropColumn('customer_email');
                }
            });
        }
    }
};
