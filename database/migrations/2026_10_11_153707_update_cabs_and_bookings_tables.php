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
        Schema::table('cabs', function (Blueprint $table) {
            if (!Schema::hasColumn('cabs', 'vehicle_number')) {
                $table->string('vehicle_number', 50)->nullable()->after('vehicle_name');
            }
            if (!Schema::hasColumn('cabs', 'ac_option')) {
                $table->string('ac_option', 50)->default('AC')->after('vehicle_type');
            }
            if (!Schema::hasColumn('cabs', 'capacity')) {
                $table->string('capacity', 100)->nullable()->after('seating_capacity');
            }
            if (!Schema::hasColumn('cabs', 'toll_status')) {
                $table->string('toll_status', 100)->default('Toll Tax Included')->after('capacity');
            }
            if (!Schema::hasColumn('cabs', 'title')) {
                $table->string('title', 255)->nullable()->after('toll_status');
            }
            if (!Schema::hasColumn('cabs', 'route_name')) {
                $table->string('route_name', 255)->nullable()->after('title');
            }
            if (!Schema::hasColumn('cabs', 'route')) {
                $table->string('route', 255)->nullable()->after('route_name');
            }
            if (!Schema::hasColumn('cabs', 'pickup')) {
                $table->string('pickup', 255)->nullable()->after('route');
            }
            if (!Schema::hasColumn('cabs', 'destination')) {
                $table->string('destination', 255)->nullable()->after('pickup');
            }
            if (!Schema::hasColumn('cabs', 'fare')) {
                $table->decimal('fare', 10, 2)->default(1400.00)->after('destination');
            }
            if (!Schema::hasColumn('cabs', 'price')) {
                $table->decimal('price', 10, 2)->default(1400.00)->after('fare');
            }
            if (!Schema::hasColumn('cabs', 'driver_name')) {
                $table->string('driver_name', 150)->nullable()->after('price');
            }
            if (!Schema::hasColumn('cabs', 'driver_phone')) {
                $table->string('driver_phone', 50)->nullable()->after('driver_name');
            }
            if (!Schema::hasColumn('cabs', 'driver_aadhaar')) {
                $table->string('driver_aadhaar', 50)->nullable()->after('driver_phone');
            }
            if (!Schema::hasColumn('cabs', 'driver_dl')) {
                $table->string('driver_dl', 50)->nullable()->after('driver_aadhaar');
            }
            if (!Schema::hasColumn('cabs', 'luggage_capacity')) {
                $table->string('luggage_capacity', 100)->nullable()->after('driver_dl');
            }
        });

        Schema::table('cab_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('cab_bookings', 'booking_code')) {
                $table->string('booking_code', 100)->nullable()->after('booking_id');
            }
            if (!Schema::hasColumn('cab_bookings', 'vehicle_type')) {
                $table->string('vehicle_type', 255)->nullable()->after('cab_id');
            }
            if (!Schema::hasColumn('cab_bookings', 'vehicle_name')) {
                $table->string('vehicle_name', 255)->nullable()->after('vehicle_type');
            }
            if (!Schema::hasColumn('cab_bookings', 'route')) {
                $table->string('route', 255)->nullable()->after('drop_location');
            }
            if (!Schema::hasColumn('cab_bookings', 'fare')) {
                $table->decimal('fare', 10, 2)->default(0.00)->after('total_amount');
            }
            if (!Schema::hasColumn('cab_bookings', 'total_fare')) {
                $table->decimal('total_fare', 10, 2)->default(0.00)->after('fare');
            }
            if (!Schema::hasColumn('cab_bookings', 'night_surcharge')) {
                $table->decimal('night_surcharge', 10, 2)->default(0.00)->after('total_fare');
            }
            if (!Schema::hasColumn('cab_bookings', 'id_type')) {
                $table->string('id_type', 100)->default('Aadhaar Card')->after('customer_phone');
            }
            if (!Schema::hasColumn('cab_bookings', 'id_no')) {
                $table->string('id_no', 100)->nullable()->after('id_type');
            }
            if (!Schema::hasColumn('cab_bookings', 'driver')) {
                $table->string('driver', 255)->nullable()->after('driver_id');
            }
            if (!Schema::hasColumn('cab_bookings', 'driver_name')) {
                $table->string('driver_name', 150)->nullable()->after('driver');
            }
            if (!Schema::hasColumn('cab_bookings', 'driver_phone')) {
                $table->string('driver_phone', 50)->nullable()->after('driver_name');
            }
            if (!Schema::hasColumn('cab_bookings', 'driver_vehicle_number')) {
                $table->string('driver_vehicle_number', 50)->nullable()->after('driver_phone');
            }
            if (!Schema::hasColumn('cab_bookings', 'status')) {
                $table->string('status', 100)->default('Confirmed & Paid')->after('booking_status');
            }
        });

        if (!Schema::hasTable('cab_locations')) {
            Schema::create('cab_locations', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('type', 50)->default('Both');
                $table->string('status', 50)->default('Active');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('cab_vehicles')) {
            Schema::create('cab_vehicles', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('type', 100)->default('Standard Taxi');
                $table->string('capacity', 100)->default('4 Passengers + 1 Driver');
                $table->decimal('price', 10, 2)->default(1400.00);
                $table->decimal('fare', 10, 2)->default(1400.00);
                $table->decimal('fare_factor', 5, 2)->default(1.00);
                $table->string('status', 50)->default('Active');
                $table->string('image', 255)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe reversible logic
    }
};
