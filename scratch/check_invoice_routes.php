<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

/** @var \Illuminate\Foundation\Http\Kernel $kernel */
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$routes = [
    '/admin/invoices',
    '/admin/invoices/export',
];

echo "=== INVOICE & BILLING MODULE VERIFICATION ===\n\n";

foreach ($routes as $uri) {
    $request = Illuminate\Http\Request::create($uri, 'GET');
    $response = $kernel->handle($request);
    $status = $response->getStatusCode();
    echo sprintf("[%s] GET %s -> Status: %d %s\n", $status === 200 ? 'OK' : 'FAIL', $uri, $status, $status === 200 ? 'SUCCESS' : 'ERROR');
    if ($status !== 200 && isset($response->exception)) {
        echo "   Exception: " . $response->exception->getMessage() . " in " . $response->exception->getFile() . ":" . $response->exception->getLine() . "\n";
    }
}

echo "\nDone testing invoices module!\n";
