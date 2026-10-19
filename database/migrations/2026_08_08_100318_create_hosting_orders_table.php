<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hosting_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('hosting_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->string('plan_name');
            $table->string('hosting_name');
            $table->decimal('price', 10, 2);
            $table->string('period')->default('monthly');
            $table->string('razorpay_order_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->enum('status', ['pending', 'processing', 'active', 'expired', 'cancelled'])->default('pending');
            $table->json('payment_response')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hosting_orders');
    }
};
