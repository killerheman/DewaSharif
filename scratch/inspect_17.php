<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$o = Illuminate\Support\Facades\DB::table('shop_orders')->where('id', 17)->first();
echo "MySQL shop_orders ID 17:\n";
print_r($o);

$dsOrders = \App\Helpers\DataStore::getCollection('shop_orders');
foreach ($dsOrders as $dso) {
    if ((string)($dso['id'] ?? '') === '17') {
        echo "\nDataStore shop_orders ID 17:\n";
        print_r($dso);
    }
}
