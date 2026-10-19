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
        Schema::create('transactions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('invoice_id')->nullable()->constrained()->nullOnDelete();

            $table->string('invoice_no')->nullable();

            $table->string('gateway');
            $table->enum('gateway_type',['Razorpay','PayPal']);

            $table->string('order_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('transaction_id')->nullable()->unique();

            $table->decimal('amount',10,2)->default(0);
            $table->decimal('gst',10,2)->default(0);
            $table->decimal('vendor_amount',10,2)->default(0);
            $table->decimal('net_amount',10,2)->default(0);

            $table->string('currency',10)->default('INR');

            $table->enum('payment_status',['Pending','Paid','Failed','Refunded'])
                  ->default('Pending');

            $table->json('response')->nullable();

            $table->timestamp('paid_at')->nullable();

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
        Schema::dropIfExists('transactions');
    }
};