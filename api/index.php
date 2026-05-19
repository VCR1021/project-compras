<?php

require __DIR__ . '/../vendor/autoload.php';

// Crear directorio temporal para almacenamiento de Laravel en Vercel
$tmpStorage = '/tmp/laravel';
if (!is_dir("$tmpStorage/storage/framework/views")) {
    mkdir("$tmpStorage/storage/framework/views", 0755, true);
    mkdir("$tmpStorage/storage/framework/cache/data", 0755, true);
    mkdir("$tmpStorage/storage/framework/sessions", 0755, true);
    mkdir("$tmpStorage/storage/logs", 0755, true);
    mkdir("$tmpStorage/bootstrap/cache", 0755, true);
}

// Inicializar la aplicación
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Redireccionar las rutas de Laravel a la carpeta temporal volátil
$app->useStoragePath("$tmpStorage/storage");
$app->useBootstrapPath("$tmpDir/bootstrap");

// Forzar la configuración de vistas al directorio temporal
config(['view.compiled' => "$tmpStorage/storage/framework/views"]);

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$response->send();
$kernel->terminate($request, $response);