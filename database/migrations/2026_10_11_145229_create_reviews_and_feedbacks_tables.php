<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Reviews Table for Hotels, Cabs, and Sacred Products
        if (!Schema::hasTable('reviews')) {
            Schema::create('reviews', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
                $table->enum('service_type', ['shop', 'hotel', 'cab'])->default('shop');
                $table->unsignedBigInteger('item_id')->nullable()->comment('Product ID, Hotel ID, or Cab ID');
                $table->string('item_name')->nullable();
                $table->string('customer_name');
                $table->string('customer_phone')->nullable();
                $table->string('customer_email')->nullable();
                $table->tinyInteger('rating')->default(5)->comment('Rating 1 to 5 stars');
                $table->string('title')->nullable();
                $table->text('comment');
                $table->string('image')->nullable();
                $table->enum('status', ['approved', 'pending', 'rejected'])->default('approved');
                $table->timestamps();
            });
        }

        // 2. Feedbacks Table for Hotels, Cabs, Sacred Store & General Site
        if (!Schema::hasTable('feedbacks')) {
            Schema::create('feedbacks', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
                $table->enum('service_type', ['shop', 'hotel', 'cab', 'general'])->default('general');
                $table->string('customer_name');
                $table->string('customer_phone')->nullable();
                $table->string('customer_email')->nullable();
                $table->string('subject')->nullable();
                $table->text('message');
                $table->tinyInteger('rating')->nullable()->comment('Optional satisfaction 1-5');
                $table->enum('status', ['new', 'reviewed', 'archived'])->default('new');
                $table->timestamps();
            });
        }

        // 3. Add helper columns to shop_products if missing
        if (Schema::hasTable('shop_products')) {
            Schema::table('shop_products', function (Blueprint $table) {
                if (!Schema::hasColumn('shop_products', 'category_slug')) {
                    $table->string('category_slug')->nullable()->after('category_id');
                }
                if (!Schema::hasColumn('shop_products', 'volume_ml')) {
                    $table->string('volume_ml')->nullable()->after('stock_quantity');
                }
                if (!Schema::hasColumn('shop_products', 'size_options')) {
                    $table->string('size_options')->nullable()->after('volume_ml');
                }
                if (!Schema::hasColumn('shop_products', 'fabric_material')) {
                    $table->string('fabric_material')->nullable()->after('size_options');
                }
                if (!Schema::hasColumn('shop_products', 'mrp')) {
                    $table->decimal('mrp', 10, 2)->nullable()->after('price');
                }
            });
        }

        // 4. Add helper columns to shop_orders if missing
        if (Schema::hasTable('shop_orders')) {
            Schema::table('shop_orders', function (Blueprint $table) {
                if (!Schema::hasColumn('shop_orders', 'items_summary')) {
                    $table->text('items_summary')->nullable()->after('shipping_address');
                }
                if (!Schema::hasColumn('shop_orders', 'payment_id')) {
                    $table->string('payment_id')->nullable()->after('paid_amount');
                }
                if (!Schema::hasColumn('shop_orders', 'fateha_name')) {
                    $table->string('fateha_name')->nullable()->after('order_status');
                }
                if (!Schema::hasColumn('shop_orders', 'niyaz_date')) {
                    $table->string('niyaz_date')->nullable()->after('fateha_name');
                }
                if (!Schema::hasColumn('shop_orders', 'distribution_type')) {
                    $table->string('distribution_type')->nullable()->after('niyaz_date');
                }
                if (!Schema::hasColumn('shop_orders', 'is_degh')) {
                    $table->tinyInteger('is_degh')->default(0)->after('distribution_type');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
        Schema::dropIfExists('reviews');
    }
};
