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
        if (Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'server_backup_fee')) {
                    $table->decimal('server_backup_fee', 10, 2)->default(199.00)->after('domain_privacy_fee');
                }
                if (!Schema::hasColumn('settings', 'server_security_fee')) {
                    $table->decimal('server_security_fee', 10, 2)->default(299.00)->after('server_backup_fee');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn(['server_backup_fee', 'server_security_fee']);
            });
        }
    }
};
