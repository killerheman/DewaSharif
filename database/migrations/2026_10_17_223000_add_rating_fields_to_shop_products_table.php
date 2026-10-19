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
        if (Schema::hasTable('shop_products')) {
            Schema::table('shop_products', function (Blueprint $table) {
                if (!Schema::hasColumn('shop_products', 'rating')) {
                    $table->decimal('rating', 3, 1)->default(5.0)->nullable()->after('description');
                }
                if (!Schema::hasColumn('shop_products', 'reviews_count')) {
                    $table->string('reviews_count')->default('240+ Niyaz Bookings')->nullable()->after('rating');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('shop_products')) {
            Schema::table('shop_products', function (Blueprint $table) {
                if (Schema::hasColumn('shop_products', 'rating')) {
                    $table->dropColumn('rating');
                }
                if (Schema::hasColumn('shop_products', 'reviews_count')) {
                    $table->dropColumn('reviews_count');
                }
            });
        }
    }
};
