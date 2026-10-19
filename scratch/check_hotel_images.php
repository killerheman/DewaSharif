<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$hotels = DB::table('hotels')->get();
foreach ($hotels as $h) {
    echo "Hotel ID: {$h->id} | Name: {$h->name}\n";
    echo "  Price: {$h->price} | PricePerNight: {$h->price_per_night}\n";
    echo "  Image: {$h->image} [File exists: " . (file_exists(public_path($h->image)) ? 'YES' : 'NO') . "]\n";
    echo "  Main: {$h->image_main} [File exists: " . (file_exists(public_path($h->image_main)) ? 'YES' : 'NO') . "]\n";
    echo "  Reception: {$h->image_reception} [File exists: " . (file_exists(public_path($h->image_reception)) ? 'YES' : 'NO') . "]\n";
    echo "  Room: {$h->image_room} [File exists: " . (file_exists(public_path($h->image_room)) ? 'YES' : 'NO') . "]\n";
    echo "  Bathroom: {$h->image_bathroom} [File exists: " . (file_exists(public_path($h->image_bathroom)) ? 'YES' : 'NO') . "]\n";
    echo "  Extra: {$h->image_extra} [File exists: " . (file_exists(public_path($h->image_extra)) ? 'YES' : 'NO') . "]\n";
    echo "--------------------------------------------------------------------\n";
}
