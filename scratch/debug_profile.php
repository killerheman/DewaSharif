<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

/** @var \Illuminate\Foundation\Http\Kernel $kernel */
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

$request = Illuminate\Http\Request::create('/admin/profile', 'GET');
$response = $kernel->handle($request);

echo "Status: " . $response->getStatusCode() . "\n";
if (isset($response->exception)) {
    echo "Exception: " . $response->exception->getMessage() . " in " . $response->exception->getFile() . ":" . $response->exception->getLine() . "\n";
} else {
    echo "Content snippet:\n" . substr(strip_tags($response->getContent()), 0, 500) . "\n";
}
