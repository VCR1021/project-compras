<?php

// 1. Cargar el autoloader nativo
require __DIR__ . '/../vendor/autoload.php';

// 2. Inicializar la aplicación original de Laravel 11
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. ¡EL TRUCO! Virtualizar el almacenamiento antes de que el Kernel arranque
$app->useStoragePath('/tmp/storage');

// 4. Crear la estructura de carpetas volátiles
$dirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/storage/bootstrap/cache'
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// 5. Procesar la petición y devolver la respuesta al navegador
$app->handleRequest(Illuminate\Http\Request::capture());