<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

/** @var \Illuminate\Foundation\Http\Kernel $kernel */
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$request = Illuminate\Http\Request::create('/admin/dashboard', 'GET');
$response = $kernel->handle($request);

echo "=== ADMIN DASHBOARD VERIFICATION ===\n\n";
echo "Status: " . $response->getStatusCode() . "\n";
if ($response->getStatusCode() === 200) {
    echo "SUCCESS: Dashboard rendered perfectly!\n";
} else if (isset($response->exception)) {
    echo "Exception: " . $response->exception->getMessage() . "\n";
}
