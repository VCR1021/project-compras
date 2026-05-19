<?php
require __DIR__ . '/../vercel-bootstrap.php';
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Inyectar rutas temporales sin llamar a funciones de Laravel (config)
$app->useStoragePath('/tmp/storage');
$app->useBootstrapPath('/tmp/bootstrap');

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();
$kernel->terminate($request, $response);