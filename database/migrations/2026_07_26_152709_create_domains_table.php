<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('domains', function (Blueprint $table) {

            $table->id();

            $table->string('extension')->unique();

            $table->decimal('register_price',10,2);

            $table->decimal('renewal_price',10,2);

            $table->decimal('transfer_price',10,2);

            $table->decimal('bulk_transfer_price',10,2)->nullable();

            $table->string('offer')->nullable();

            $table->text('description')->nullable();

            /* Future API Compatible */

            $table->string('registrar')->nullable();

            $table->string('registrar_domain_id')->nullable();

            $table->string('currency',10)->default('INR');

            $table->unsignedTinyInteger('min_year')->default(1);

            $table->unsignedTinyInteger('max_year')->default(10);

            $table->boolean('is_premium')->default(0);

            $table->boolean('privacy_protection')->default(0);

            $table->boolean('dns_management')->default(0);

            $table->boolean('email_forwarding')->default(0);

            /* SEO */

            $table->string('meta_title')->nullable();

            $table->text('meta_description')->nullable();

            $table->text('meta_keywords')->nullable();

            $table->string('image_alt')->nullable();

            $table->string('image_title')->nullable();

            /* Common */

            $table->integer('sort_order')->default(1);

            $table->boolean('is_active')->default(1);

            $table->softDeletes();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};