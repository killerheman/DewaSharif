<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$prods = Illuminate\Support\Facades\DB::table('shop_products')->select('id', 'name', 'category_id', 'slug', 'price', 'packaging_fee')->get();
foreach($prods as $p) {
    echo "ID: {$p->id} | Name: {$p->name} | CatID: {$p->category_id} | Slug: {$p->slug} | PkgFee: {$p->packaging_fee}\n";
}

$cats = Illuminate\Support\Facades\DB::table('shop_categories')->get();
echo "\n--- Categories ---\n";
foreach($cats as $c) {
    echo "ID: {$c->id} | Name: {$c->name} | Slug: {$c->slug}\n";
}
