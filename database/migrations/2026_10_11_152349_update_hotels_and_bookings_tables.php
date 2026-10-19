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
        Schema::table('hotels', function (Blueprint $table) {
            if (!Schema::hasColumn('hotels', 'price')) {
                $table->decimal('price', 10, 2)->default(1499.00)->after('available_rooms');
            }
            if (!Schema::hasColumn('hotels', 'price_per_night')) {
                $table->decimal('price_per_night', 10, 2)->default(1499.00)->after('price');
            }
            if (!Schema::hasColumn('hotels', 'mrp')) {
                $table->decimal('mrp', 10, 2)->default(1999.00)->after('price_per_night');
            }
            if (!Schema::hasColumn('hotels', 'category')) {
                $table->string('category', 100)->default('queen_ac')->after('mrp');
            }
            if (!Schema::hasColumn('hotels', 'category_name')) {
                $table->string('category_name', 150)->default('Queen Size AC')->after('category');
            }
            if (!Schema::hasColumn('hotels', 'room_type')) {
                $table->string('room_type', 150)->default('Deluxe AC Room')->after('category_name');
            }
            if (!Schema::hasColumn('hotels', 'ac_type')) {
                $table->string('ac_type', 50)->default('AC')->after('room_type');
            }
            if (!Schema::hasColumn('hotels', 'bed_type')) {
                $table->string('bed_type', 100)->default('Double Bed')->after('ac_type');
            }
            if (!Schema::hasColumn('hotels', 'max_adults')) {
                $table->integer('max_adults')->default(2)->after('bed_type');
            }
            if (!Schema::hasColumn('hotels', 'max_children')) {
                $table->integer('max_children')->default(1)->after('max_adults');
            }
            if (!Schema::hasColumn('hotels', 'bath_type')) {
                $table->string('bath_type', 150)->default('Attached Western Bath')->after('max_children');
            }
            if (!Schema::hasColumn('hotels', 'location')) {
                $table->string('location', 255)->nullable()->after('bath_type');
            }
            if (!Schema::hasColumn('hotels', 'distance')) {
                $table->string('distance', 100)->nullable()->after('location');
            }
            if (!Schema::hasColumn('hotels', 'amenities')) {
                $table->text('amenities')->nullable()->after('distance');
            }
            if (!Schema::hasColumn('hotels', 'image')) {
                $table->string('image', 255)->nullable()->after('cover_image');
            }
            if (!Schema::hasColumn('hotels', 'image_main')) {
                $table->string('image_main', 255)->nullable()->after('image');
            }
            if (!Schema::hasColumn('hotels', 'image_reception')) {
                $table->string('image_reception', 255)->nullable()->after('image_main');
            }
            if (!Schema::hasColumn('hotels', 'image_room')) {
                $table->string('image_room', 255)->nullable()->after('image_reception');
            }
            if (!Schema::hasColumn('hotels', 'image_bathroom')) {
                $table->string('image_bathroom', 255)->nullable()->after('image_room');
            }
            if (!Schema::hasColumn('hotels', 'image_extra')) {
                $table->string('image_extra', 255)->nullable()->after('image_bathroom');
            }
        });

        Schema::table('hotel_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('hotel_bookings', 'booking_code')) {
                $table->string('booking_code', 100)->nullable()->after('booking_id');
            }
            if (!Schema::hasColumn('hotel_bookings', 'booking_number')) {
                $table->string('booking_number', 100)->nullable()->after('booking_code');
            }
            if (!Schema::hasColumn('hotel_bookings', 'hotel_name')) {
                $table->string('hotel_name', 255)->nullable()->after('hotel_id');
            }
            if (!Schema::hasColumn('hotel_bookings', 'room_name')) {
                $table->string('room_name', 255)->nullable()->after('hotel_name');
            }
            if (!Schema::hasColumn('hotel_bookings', 'price_per_night')) {
                $table->decimal('price_per_night', 10, 2)->default(0.00)->after('total_amount');
            }
            if (!Schema::hasColumn('hotel_bookings', 'id_type')) {
                $table->string('id_type', 100)->default('Aadhaar Card')->after('customer_whatsapp');
            }
            if (!Schema::hasColumn('hotel_bookings', 'id_no')) {
                $table->string('id_no', 100)->nullable()->after('id_type');
            }
            if (!Schema::hasColumn('hotel_bookings', 'payment_id')) {
                $table->string('payment_id', 255)->nullable()->after('pending_amount');
            }
            if (!Schema::hasColumn('hotel_bookings', 'status')) {
                $table->string('status', 100)->default('Confirmed & Paid')->after('booking_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe reversible logic
    }
};
