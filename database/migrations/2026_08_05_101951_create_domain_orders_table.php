<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('domain_orders', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('domain');

            $table->string('extension');

            $table->decimal('price',10,2);

            $table->string('currency')
                ->default('INR');


            $table->enum('status',[
                'pending',
                'payment_pending',
                'processing',
                'registered',
                'failed'
            ])->default('pending');


            // OpenProvider
            $table->string('openprovider_order_id')
                ->nullable();

            $table->string('provider_domain_id')
                ->nullable();


            // Razorpay
            $table->string('razorpay_order_id')
                ->nullable();


            // Dates
            $table->date('registered_at')
                ->nullable();

            $table->date('expires_at')
                ->nullable();


            // API Responses
            $table->json('payment_response')
                ->nullable();

            $table->json('provider_response')
                ->nullable();


            $table->softDeletes();

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('domain_orders');
    }
};
