<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$raw = file_get_contents(storage_path('app/data_store.json'));
$data = json_decode($raw, true);

if (isset($data['products']) && is_array($data['products'])) {
    foreach ($data['products'] as &$p) {
        $img = $p['image'] ?? '';
        // Remove domain
        $img = preg_replace('#^https?://dewasharif\.com#', '', $img);
        $img = preg_replace('#^https?://127\.0\.0\.1:8000#', '', $img);
        
        $cat = $p['category'] ?? 'attar';
        $name = strtolower($p['name'] ?? '');
        
        if ($cat === 'degh') {
            if (str_contains($name, 'mutton')) {
                $img = '/home/images/dewasharif/dewapage/degh_mutton_biryani.jpg';
            } elseif (str_contains($name, 'chicken')) {
                $img = '/home/images/dewasharif/dewapage/degh_chicken_biryani.jpg';
            } elseif (str_contains($name, 'yellow')) {
                $img = '/home/images/dewasharif/dewapage/degh_zarda_yellow.jpg';
            } elseif (str_contains($name, 'zarda') || str_contains($name, 'kesari')) {
                $img = '/home/images/dewasharif/dewapage/degh_zarda_kesari.jpg';
            } elseif (str_contains($name, 'kheer')) {
                $img = '/home/images/dewasharif/dewapage/degh_zafraani_kheer.jpg';
            } else {
                $img = '/home/images/dewasharif/dewapage/degh_mutton_biryani.jpg';
            }
        } elseif ($cat === 'attar') {
            $img = '/home/images/dewasharif/dewapage/attar_bottle.jpg';
        } elseif ($cat === 'clothing') {
            $img = '/home/images/dewasharif/dewapage/sufi_clothing.jpg';
        } elseif ($cat === 'clay') {
            $img = '/home/images/dewasharif/dewapage/clay_pots.jpg';
        } elseif ($cat === 'toys') {
            $img = '/home/images/dewasharif/dewapage/mela_toys.jpg';
        } elseif ($cat === 'islamic') {
            $img = '/home/images/dewasharif/dewapage/velvet_chadar.jpg';
        }
        $p['image'] = '/' . ltrim($img, '/');
    }
    unset($p);
}

file_put_contents(storage_path('app/data_store.json'), json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
echo "Successfully updated " . count($data['products'] ?? []) . " products in data_store.json!\n";

// Also sync to MySQL DB table if exists
if (\Illuminate\Support\Facades\Schema::hasTable('products')) {
    foreach ($data['products'] as $p) {
        \Illuminate\Support\Facades\DB::table('products')->updateOrInsert(
            ['id' => $p['id']],
            [
                'name' => $p['name'],
                'category' => $p['category'],
                'price' => $p['price'],
                'mrp' => $p['mrp'] ?? $p['price'],
                'stock' => $p['stock'] ?? 50,
                'image' => $p['image'],
                'description' => $p['description'] ?? '',
                'status' => $p['status'] ?? 'Active',
                'updated_at' => date('Y-m-d H:i:s')
            ]
        );
    }
    echo "Successfully synced to MySQL 'products' table!\n";
}
