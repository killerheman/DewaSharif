<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cabs', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_name');
            $table->string('vehicle_type'); // Sedan, SUV, E-Rickshaw, Auto
            $table->integer('seating_capacity')->default(4);
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('cab_routes', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->string('destination');
            $table->decimal('distance_km', 8, 2)->default(0);
            $table->decimal('sedan_fare', 10, 2);
            $table->decimal('suv_fare', 10, 2);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('cab_drivers', function (Blueprint $table) {
            $table->id();
            $table->string('driver_name');
            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->string('license_no')->nullable();
            $table->string('vehicle_number');
            $table->enum('status', ['available', 'busy', 'offline'])->default('available');
            $table->timestamps();
        });

        Schema::create('cab_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id')->unique();
            $table->foreignId('cab_id')->nullable()->constrained('cabs')->onDelete('set null');
            $table->foreignId('route_id')->nullable()->constrained('cab_routes')->onDelete('set null');
            $table->foreignId('driver_id')->nullable()->constrained('cab_drivers')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('pickup_location');
            $table->string('drop_location');
            $table->date('pickup_date');
            $table->string('pickup_time');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('pending_amount', 10, 2)->default(0);
            $table->enum('payment_mode', ['full', 'advance', 'whatsapp'])->default('whatsapp');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('booking_status', ['pending', 'assigned', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cab_bookings');
        Schema::dropIfExists('cab_drivers');
        Schema::dropIfExists('cab_routes');
        Schema::dropIfExists('cabs');
    }
};
