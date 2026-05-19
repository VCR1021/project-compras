<?php

// Definimos el directorio temporal donde Vercel SI nos deja escribir
$tmpDir = '/tmp/laravel';

// Crear estructura de carpetas necesarias en /tmp
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

// Inicializar la aplicación
$app = require_once __DIR__ . '/../bootstrap/app.php';

// REDIRECCIÓN DINÁMICA DE RUTAS: 
// Esto es lo que evita que Laravel busque las carpetas originales que no tienen permisos
$app->useStoragePath("$tmpDir/storage");
$app->useBootstrapPath("$tmpDir/bootstrap");

// Inyectar configuraciones críticas antes de procesar la petición
config(['view.compiled' => "$tmpDir/storage/framework/views"]);
config(['session.driver' => 'cookie']); // Las sesiones en archivo fallarán en Vercel

// Procesar la petición
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$response->send();
$kernel->terminate($request, $response);