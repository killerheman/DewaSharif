<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$products = \App\Helpers\DataStore::getCollection('products');
echo "TOTAL PRODUCTS: " . count($products) . "\n";
foreach ($products as $p) {
    echo "ID: " . ($p['id'] ?? '') . " | Cat: " . ($p['category'] ?? '') . " | Name: " . ($p['name'] ?? '') . " | Image: " . ($p['image'] ?? '') . "\n";
}
