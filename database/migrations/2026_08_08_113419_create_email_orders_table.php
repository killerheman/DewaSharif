<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('plan_name');
            $table->string('provider'); // Google/Microsoft/HostLok
            $table->string('domain_name');
            $table->string('desired_email');
            $table->decimal('price', 10, 2);
            $table->string('period');
            $table->string('razorpay_order_id')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_orders');
    }
};
