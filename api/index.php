<?php

// 1. Crear estructura de almacenamiento en la memoria volátil de Vercel (/tmp)
$tmpStorage = '/tmp/storage';
$dirs = [
    "$tmpStorage/framework/views",
    "$tmpStorage/framework/cache/data",
    "$tmpStorage/framework/sessions",
    "$tmpStorage/logs",
    "/tmp/bootstrap/cache"
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

// 2. Inyectar variable de entorno para avisarle a Laravel dónde escribir
$_ENV['APP_STORAGE'] = $tmpStorage;

// 3. Arrancar la aplicación original
require __DIR__ . '/../public/index.php';