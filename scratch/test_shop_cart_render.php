<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Helpers\DataStore;

echo "=== TESTING SHOP & CART RENDERING ===" . PHP_EOL;

$products = DataStore::getCollection('products');
$categories = DataStore::getCollection('shop_categories');
$reviews = DB::table('reviews')->where('service_type', 'shop')->get();

$shopHtml = view('home.shops.shop', compact('products', 'categories', 'reviews'))->render();
echo "home.shops.shop rendered successfully! Length: " . strlen($shopHtml) . " bytes" . PHP_EOL;

$cartHtml = view('home.shops.cart')->render();
echo "home.shops.cart rendered successfully! Length: " . strlen($cartHtml) . " bytes" . PHP_EOL;
