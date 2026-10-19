<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('address');
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->integer('available_rooms')->default(10);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('hotel_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id')->unique();
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_whatsapp')->nullable();
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('persons')->default(2);
            $table->integer('rooms')->default(1);
            $table->integer('nights')->default(1);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('pending_amount', 10, 2)->default(0);
            $table->enum('payment_mode', ['full', 'advance', 'whatsapp'])->default('whatsapp');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('hotel_status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->enum('booking_status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->enum('settlement_status', ['pending', 'paid'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotel_bookings');
        Schema::dropIfExists('hotels');
    }
};
