<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$routes = [
    '/admin/profile',
    '/admin/change-password',
    '/admin/settings',
];

echo "=== ACCOUNT & SETTINGS MODULE VERIFICATION ===\n\n";

foreach ($routes as $uri) {
    $request = Illuminate\Http\Request::create($uri, 'GET');
    try {
        $response = $kernel->handle($request);
        $status = $response->getStatusCode();
        echo sprintf("[%s] %s -> Status: %d %s\n", $status === 200 ? 'OK' : 'FAIL', $uri, $status, $status === 200 ? 'SUCCESS' : 'ERROR');
        if ($status !== 200 && method_exists($response, 'exception') && $response->exception) {
            echo "   Exception: " . $response->exception->getMessage() . " in " . $response->exception->getFile() . ":" . $response->exception->getLine() . "\n";
        }
    } catch (\Throwable $e) {
        echo sprintf("[ERROR] %s -> Exception: %s (File: %s:%d)\n", $uri, $e->getMessage(), $e->getFile(), $e->getLine());
    }
}

echo "\nDone testing account module!\n";
