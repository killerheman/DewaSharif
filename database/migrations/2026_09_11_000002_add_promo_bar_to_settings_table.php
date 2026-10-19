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
                if (!Schema::hasColumn('settings', 'promo_bar_enabled')) {
                    $table->boolean('promo_bar_enabled')->default(0)->after('domain_privacy_fee');
                }
                if (!Schema::hasColumn('settings', 'promo_bar_text')) {
                    $table->string('promo_bar_text')->nullable()->after('promo_bar_enabled');
                }
                if (!Schema::hasColumn('settings', 'promo_bar_coupon')) {
                    $table->string('promo_bar_coupon')->nullable()->after('promo_bar_text');
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
                $table->dropColumn(['promo_bar_enabled', 'promo_bar_text', 'promo_bar_coupon']);
            });
        }
    }
};
