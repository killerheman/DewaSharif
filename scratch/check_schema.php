<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "=== shop_products columns ===\n";
print_r(Schema::getColumnListing('shop_products'));

echo "\n=== shop_categories columns ===\n";
print_r(Schema::getColumnListing('shop_categories'));

echo "\n=== shop_categories count & sample ===\n";
$cats = DB::table('shop_categories')->get();
foreach ($cats as $c) {
    echo "ID: {$c->id} | Name: {$c->name} | Slug: {$c->slug} | Status: {$c->status} | Order: {$c->order_num}\n";
}
