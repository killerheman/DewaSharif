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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->integer('offer_percentage')->default(0);
            $table->decimal('price', 10, 2);
            $table->enum('period', ['month', 'year']);

            // Add Blade me comma se title add honge
            $table->longText('description')->nullable();

            // Polymorphic Relation
             $table->string('common_type');
            $table->unsignedBigInteger('common_id');
           

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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('plans');
        Schema::enableForeignKeyConstraints();
    }
};
