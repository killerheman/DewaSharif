<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Helpers\DataStore;

$dbOrder = DB::table('shop_orders')->where('id', 17)->first();
echo "--- DB ORDER 17 ---\n";
print_r($dbOrder);

$dsOrders = DataStore::getCollection('shop_orders');
foreach ($dsOrders as $o) {
    $id = is_array($o) ? ($o['id'] ?? null) : ($o->id ?? null);
    if ((string)$id === '17') {
        echo "--- DATASTORE ORDER 17 ---\n";
        print_r($o);
        break;
    }
}
