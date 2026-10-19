<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {

            $table->id();

            $table->string('title');

            $table->text('message');

            $table->enum('type',['common','individual'])
                ->default('common');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->date('start_date')
                ->nullable();

            $table->date('end_date')
                ->nullable();

            $table->boolean('show_before_login')
                ->default(false);

            $table->boolean('show_after_login')
                ->default(true);

            $table->boolean('is_active')
                ->default(1);

            $table->softDeletes();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};