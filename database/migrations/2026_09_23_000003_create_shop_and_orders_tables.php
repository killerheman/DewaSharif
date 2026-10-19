<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shop_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('parent_id')->nullable()->constrained('shop_categories')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('shop_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('shop_categories')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(50);
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('shop_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_whatsapp')->nullable();
            $table->text('shipping_address');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->enum('payment_mode', ['online', 'cod'])->default('online');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('order_status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->string('courier_name')->nullable();
            $table->string('tracking_number')->nullable();
            $table->timestamp('dispatched_at')->nullable();
            $table->timestamps();
        });

        Schema::create('shop_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('shop_orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('shop_products')->onDelete('cascade');
            $table->string('product_name');
            $table->decimal('unit_price', 10, 2);
            $table->integer('quantity');
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shop_order_items');
        Schema::dropIfExists('shop_orders');
        Schema::dropIfExists('shop_products');
        Schema::dropIfExists('shop_categories');
    }
};
