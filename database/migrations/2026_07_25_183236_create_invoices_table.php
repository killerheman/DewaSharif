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
        Schema::create('invoices', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('invoice_no')->unique();

            $table->string('payment_id')->nullable();
            $table->string('subscription_id')->nullable();

            $table->enum('service_type', ['Hosting', 'Server', 'Domain'])->nullable();
            $table->string('service_name')->nullable();

            $table->string('period')->nullable();

            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('gst', 10, 2)->default(0);
            $table->decimal('vendor_amount', 10, 2)->default(0);
            $table->decimal('net_amount', 10, 2)->default(0);

            $table->enum('payment_status', ['Pending', 'Paid', 'Failed', 'Refunded'])
                  ->default('Pending');

            $table->text('billing_address')->nullable();
            $table->longText('plan_features')->nullable();

            $table->date('invoice_date')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};