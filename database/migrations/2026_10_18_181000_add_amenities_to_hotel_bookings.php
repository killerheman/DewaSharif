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
        if (Schema::hasTable('hotel_bookings') && !Schema::hasColumn('hotel_bookings', 'amenities')) {
            Schema::table('hotel_bookings', function (Blueprint $table) {
                $table->text('amenities')->nullable()->after('room_name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('hotel_bookings') && Schema::hasColumn('hotel_bookings', 'amenities')) {
            Schema::table('hotel_bookings', function (Blueprint $table) {
                $table->dropColumn('amenities');
            });
        }
    }
};
