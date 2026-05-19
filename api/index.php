<?php

// Definir la ruta base temporal
$tmpDir = '/tmp/laravel';

// Crear estructura de carpetas necesarias
$dirs = [
    "$tmpDir/storage/framework/views",
    "$tmpDir/storage/framework/cache/data",
    "$tmpDir/storage/framework/sessions",
    "$tmpDir/storage/logs",
    "$tmpDir/bootstrap/cache"
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Cargar autoloader
require __DIR__ . '/../vendor/autoload.php';

// Inicializar Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Sobrescribir rutas de almacenamiento
$app->useStoragePath("$tmpDir/storage");
$app->useBootstrapPath("$tmpDir/bootstrap");

// ¡IMPORTANTE! 
// No llames a config() aquí. Vamos a inyectar las configuraciones 
// mediante variables de entorno que Laravel leerá automáticamente.
putenv("VIEW_COMPILED_PATH=$tmpDir/storage/framework/views");
$_ENV['VIEW_COMPILED_PATH'] = "$tmpDir/storage/framework/views";

// Manejar la petición
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$response->send();
$kernel->terminate($request, $response);