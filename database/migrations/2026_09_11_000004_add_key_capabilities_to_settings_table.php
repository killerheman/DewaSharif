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
                if (!Schema::hasColumn('settings', 'key_capabilities_heading')) {
                    $table->string('key_capabilities_heading')->nullable()->default('Key Capabilities');
                }
                if (!Schema::hasColumn('settings', 'key_capabilities_desc')) {
                    $table->text('key_capabilities_desc')->nullable();
                }
                if (!Schema::hasColumn('settings', 'key_capabilities_items')) {
                    $table->json('key_capabilities_items')->nullable();
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
                $table->dropColumn(['key_capabilities_heading', 'key_capabilities_desc', 'key_capabilities_items']);
            });
        }
    }
};
