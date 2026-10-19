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
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'sales_phone')) {
                $table->string('sales_phone', 20)->nullable()->after('support_phone');
            }
            if (!Schema::hasColumn('settings', 'billing_email')) {
                $table->string('billing_email')->nullable()->after('sales_email');
            }
            if (!Schema::hasColumn('settings', 'phone')) {
                $table->string('phone', 20)->nullable()->after('sales_phone');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['sales_phone', 'billing_email', 'phone']);
        });
    }
};
