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
        Schema::table('domain_orders', function (Blueprint $table) {
            $table->enum('type', ['register', 'transfer'])->default('register')->after('status');
            $table->string('auth_code')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('domain_orders', function (Blueprint $table) {
            $table->dropColumn(['type', 'auth_code']);
        });
    }
};
