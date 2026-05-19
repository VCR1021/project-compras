<?php

// 1. Definir el directorio temporal exclusivo para Vercel (único con permisos de escritura)
$tmpDir = '/tmp/laravel';

// 2. Crear la estructura de carpetas volátiles necesarias
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

// 3. ¡EL TRUCO MAESTRO!
// Anulamos las variables de entorno para que Laravel ignore el caché tóxico del Build
// y se vea obligado a usar las rutas limpias en la memoria RAM (/tmp)
$vars = [
    'APP_SERVICES_CACHE' => "$tmpDir/bootstrap/cache/services.php",
    'APP_PACKAGES_CACHE' => "$tmpDir/bootstrap/cache/packages.php",
    'APP_CONFIG_CACHE'   => "$tmpDir/bootstrap/cache/config.php",
    'APP_ROUTES_CACHE'   => "$tmpDir/bootstrap/cache/routes.php",
    'APP_EVENTS_CACHE'   => "$tmpDir/bootstrap/cache/events.php",
    'VIEW_COMPILED_PATH' => "$tmpDir/storage/framework/views",
];

foreach ($vars as $key => $value) {
    putenv("$key=$value");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

// 4. Cargar el autoloader de Composer
require __DIR__ . '/../vendor/autoload.php';

// 5. Inicializar la aplicación de Laravel 11
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 6. Sobrescribir las rutas de almacenamiento a nivel del núcleo
$app->useStoragePath("$tmpDir/storage");
$app->useBootstrapPath("$tmpDir/bootstrap");

// 7. Procesar la petición web y devolverla al navegador
$request = Illuminate\Http\Request::capture();
$app->handleRequest($request);