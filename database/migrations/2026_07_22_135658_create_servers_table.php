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
        Schema::create('servers', function (Blueprint $table) {

            $table->id();



            // Basic Information
            $table->string('name');
            $table->string('slug')->unique();

            // Banner
            $table->string('banner_image_1')->nullable();
            $table->string('banner_image_2')->nullable();
            $table->string('banner_title');
            $table->longText('banner_description');
            $table->string('banner_service');

            // Main Content (CKEditor)
            $table->longText('description')->nullable();

            // Image
            $table->string('image')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('image_title')->nullable();

            // Settings
            $table->integer('sort_order')->default(0);
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
        Schema::dropIfExists('servers');
    }
};
