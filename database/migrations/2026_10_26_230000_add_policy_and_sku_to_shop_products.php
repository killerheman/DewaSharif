<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('shop_products')) {
            Schema::table('shop_products', function (Blueprint $table) {
                if (!Schema::hasColumn('shop_products', 'sku')) {
                    $table->string('sku', 50)->nullable()->after('slug');
                }
                if (!Schema::hasColumn('shop_products', 'return_policy')) {
                    $table->string('return_policy', 50)->default('non_returnable')->after('status');
                }
                if (!Schema::hasColumn('shop_products', 'is_featured')) {
                    $table->boolean('is_featured')->default(false)->after('return_policy');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('shop_products')) {
            Schema::table('shop_products', function (Blueprint $table) {
                if (Schema::hasColumn('shop_products', 'sku')) {
                    $table->dropColumn('sku');
                }
                if (Schema::hasColumn('shop_products', 'return_policy')) {
                    $table->dropColumn('return_policy');
                }
                if (Schema::hasColumn('shop_products', 'is_featured')) {
                    $table->dropColumn('is_featured');
                }
            });
        }
    }
};
