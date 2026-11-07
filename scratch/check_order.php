<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$ds = App\Helpers\DataStore::getCollection('shop_orders');
foreach ($ds as $item) {
    $id = is_array($item) ? ($item['id'] ?? null) : $item->id;
    if ($id == 18) {
        print_r($item);
    }
}
