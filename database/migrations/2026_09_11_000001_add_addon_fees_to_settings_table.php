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
            if (!Schema::hasColumn('settings', 'daily_backup_fee')) {
                $table->decimal('daily_backup_fee', 10, 2)->default(0.00)->after('currency');
            }
            if (!Schema::hasColumn('settings', 'domain_privacy_fee')) {
                $table->decimal('domain_privacy_fee', 10, 2)->default(0.00)->after('daily_backup_fee');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['daily_backup_fee', 'domain_privacy_fee']);
        });
    }
};
