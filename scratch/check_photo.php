<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$u = User::first();
echo "Current User in DB:\n";
print_r($u ? $u->toArray() : "No user in DB");

$ds = \App\Helpers\DataStore::getCollection('admin_profile');
echo "\nDataStore admin_profile:\n";
print_r($ds);
