<?php

// 1. Cargar el autoloader de Composer
require __DIR__ . '/../vendor/autoload.php';

// 2. Definir el directorio temporal para Vercel
$tmpDir = '/tmp/laravel';
if (!is_dir("$tmpDir/storage/framework/views")) {
    mkdir("$tmpDir/storage/framework/views", 0755, true);
    mkdir("$tmpDir/storage/framework/cache/data", 0755, true);
    mkdir("$tmpDir/storage/framework/sessions", 0755, true);
    mkdir("$tmpDir/storage/logs", 0755, true);
    mkdir("$tmpDir/bootstrap/cache", 0755, true);
}

// 3. Inicializar la aplicación
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 4. Configurar rutas de almacenamiento y bootstrap
$app->useStoragePath("$tmpDir/storage");
$app->useBootstrapPath("$tmpDir/bootstrap");

// 5. Inyectar configuración sin llamar a la función config()
// Usamos las variables de entorno para que Laravel las detecte al arrancar
putenv("VIEW_COMPILED_PATH=$tmpDir/storage/framework/views");
$_ENV['VIEW_COMPILED_PATH'] = "$tmpDir/storage/framework/views";

// 6. Procesar la petición
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);