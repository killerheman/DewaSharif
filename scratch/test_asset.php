<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$files = [
    'degh_mutton_biryani.jpg',
    'degh_chicken_biryani.jpg',
    'degh_zarda_kesari.jpg',
    'degh_zafraani_kheer.jpg',
    'attar_bottle.jpg',
    'velvet_chadar.jpg',
    'sufi_clothing.jpg',
    'clay_pots.jpg',
    'mela_toys.jpg'
];

foreach ($files as $f) {
    $p = public_path('home/images/dewasharif/dewapage/' . $f);
    echo $f . ": " . (file_exists($p) ? "EXISTS (" . filesize($p) . " bytes)" : "MISSING") . " -> Asset: " . asset('home/images/dewasharif/dewapage/' . $f) . "\n";
}
