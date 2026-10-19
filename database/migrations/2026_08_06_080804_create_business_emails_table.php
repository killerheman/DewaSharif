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
        Schema::create('business_emails', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('domain');

            $table->string('plan_name');

            $table->date('registration_date');

            $table->date('expiry_date');

            $table->string('email_address')->nullable();

            $table->string('provider_email_id')->nullable();
            $table->text('provider_response')->nullable();

            $table->enum('status', [
                'pending',
                'active',
                'expired',
                'failed'
            ])->default('pending');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_emails');
    }
};
