<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Helpers\DataStore;

$prices = [
    1 => ['price' => 1499.00, 'price_per_night' => 1499.00, 'mrp' => 1999.00],
    2 => ['price' => 799.00, 'price_per_night' => 799.00, 'mrp' => 1100.00],
    3 => ['price' => 2499.00, 'price_per_night' => 2499.00, 'mrp' => 3800.00],
    4 => ['price' => 1899.00, 'price_per_night' => 1899.00, 'mrp' => 2600.00],
    5 => ['price' => 1599.00, 'price_per_night' => 1599.00, 'mrp' => 2400.00],
    6 => ['price' => 1199.00, 'price_per_night' => 1199.00, 'mrp' => 1500.00],
    7 => ['price' => 999.00, 'price_per_night' => 999.00, 'mrp' => 1399.00],
    8 => ['price' => 1299.00, 'price_per_night' => 1299.00, 'mrp' => 1799.00],
];

foreach ($prices as $id => $p) {
    DB::table('hotels')->where('id', $id)->update($p);
}

// Clean image URLs in hotels table
$hotels = DB::table('hotels')->get();
foreach ($hotels as $h) {
    $clean = [];
    foreach (['image', 'cover_image', 'image_main', 'image_reception', 'image_room', 'image_bathroom', 'image_extra'] as $col) {
        if (!empty($h->$col)) {
            $val = $h->$col;
            $val = str_replace([
                'http://dewasharif.com/',
                'https://dewasharif.com/',
                'http://127.0.0.1:8000/',
                'http://localhost:8000/'
            ], '', $val);
            $val = ltrim($val, '/');
            $clean[$col] = $val;
        }
    }
    if (!empty($clean)) {
        DB::table('hotels')->where('id', $h->id)->update($clean);
    }
}

// Also sync with DataStore file
$allData = DataStore::get();
if (isset($allData['hotels']) && is_array($allData['hotels'])) {
    foreach ($allData['hotels'] as &$dh) {
        $id = $dh['id'] ?? null;
        if ($id && isset($prices[$id])) {
            $dh['price'] = $prices[$id]['price'];
            $dh['price_per_night'] = $prices[$id]['price_per_night'];
            $dh['mrp'] = $prices[$id]['mrp'];
        }
        foreach (['image', 'cover_image', 'image_main', 'image_reception', 'image_room', 'image_bathroom', 'image_extra'] as $col) {
            if (!empty($dh[$col])) {
                $dh[$col] = ltrim(str_replace([
                    'http://dewasharif.com/',
                    'https://dewasharif.com/',
                    'http://127.0.0.1:8000/',
                    'http://localhost:8000/'
                ], '', $dh[$col]), '/');
            }
        }
    }
    DataStore::save($allData);
}

echo "SUCCESS: Hotels table and DataStore updated with valid prices and clean relative image paths!\n";
