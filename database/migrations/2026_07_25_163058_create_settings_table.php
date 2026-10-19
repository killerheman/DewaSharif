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
        Schema::create('settings', function (Blueprint $table) {

            $table->id();

            // General
            $table->string('website_name')->nullable();
            $table->string('website_url')->nullable();
            $table->string('website_email')->nullable();
            $table->string('website_phone',20)->nullable();
            $table->string('timezone')->default('Asia/Kolkata');
            $table->string('currency',10)->default('INR');
            $table->string('language')->default('English');
            $table->string('copyright')->nullable();

            // Company
            $table->string('company_name')->nullable();
            $table->string('gst_number')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_phone',20)->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code',20)->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();

            // Contact
            $table->string('support_email')->nullable();
            $table->string('sales_email')->nullable();
            $table->string('support_phone',20)->nullable();
            $table->string('whatsapp',20)->nullable();
            $table->longText('google_map')->nullable();
            $table->string('office_hours')->nullable();

            // Social
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();

            // Payment
            $table->string('razorpay_key')->nullable();
            $table->string('razorpay_secret')->nullable();
            $table->string('paypal_client_id')->nullable();
            $table->string('paypal_secret')->nullable();
            $table->string('phonepe_merchant_id')->nullable();
            $table->string('phonepe_salt')->nullable();
            $table->string('payu_key')->nullable();
            $table->string('payu_salt')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('google_analytics')->nullable();
            $table->string('google_tag_manager')->nullable();
            $table->string('google_site_verification')->nullable();
            $table->string('bing_site_verification')->nullable();
            $table->string('robots')->default('index,follow');

            // API
            $table->string('domain_api_url')->nullable();
            $table->string('domain_api_key')->nullable();
            $table->string('hosting_api_url')->nullable();
            $table->string('hosting_api_key')->nullable();
            $table->string('whois_api_key')->nullable();

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
        Schema::dropIfExists('settings');
    }
};