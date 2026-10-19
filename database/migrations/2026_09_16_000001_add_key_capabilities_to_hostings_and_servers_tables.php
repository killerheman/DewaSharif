<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('hostings')) {
            Schema::table('hostings', function (Blueprint $table) {
                if (!Schema::hasColumn('hostings', 'key_capabilities_heading')) {
                    $table->string('key_capabilities_heading')->nullable();
                }
                if (!Schema::hasColumn('hostings', 'key_capabilities_items')) {
                    $table->json('key_capabilities_items')->nullable();
                }
            });
        }

        if (Schema::hasTable('servers')) {
            Schema::table('servers', function (Blueprint $table) {
                if (!Schema::hasColumn('servers', 'key_capabilities_heading')) {
                    $table->string('key_capabilities_heading')->nullable();
                }
                if (!Schema::hasColumn('servers', 'key_capabilities_items')) {
                    $table->json('key_capabilities_items')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('hostings')) {
            Schema::table('hostings', function (Blueprint $table) {
                $table->dropColumn(['key_capabilities_heading', 'key_capabilities_items']);
            });
        }

        if (Schema::hasTable('servers')) {
            Schema::table('servers', function (Blueprint $table) {
                $table->dropColumn(['key_capabilities_heading', 'key_capabilities_items']);
            });
        }
    }
};
