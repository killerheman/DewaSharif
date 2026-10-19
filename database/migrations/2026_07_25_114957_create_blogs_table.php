<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {

            $table->id();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('image')->nullable();

            $table->longText('description')->nullable();

            $table->date('date')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('image_title')->nullable();

            $table->integer('sort_order')->default(1);
            $table->boolean('is_active')->default(true);

            $table->softDeletes();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};