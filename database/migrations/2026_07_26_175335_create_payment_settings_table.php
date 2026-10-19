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
        Schema::create('payment_settings', function (Blueprint $table) {

            $table->id();

            $table->enum('gateway',['Razorpay','PayPal']);

            $table->string('display_name');

            $table->string('key_id')->nullable();
            $table->string('key_secret')->nullable();

            $table->string('client_id')->nullable();
            $table->string('client_secret')->nullable();

            $table->string('merchant_id')->nullable();

            $table->string('webhook_secret')->nullable();

            $table->boolean('sandbox_mode')->default(true);

            $table->string('currency',10)->default('INR');

            $table->boolean('is_active')->default(true);

            $table->softDeletes();
            $table->timestamps();
           

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
    }
};