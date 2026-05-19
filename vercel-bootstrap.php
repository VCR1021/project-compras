<?php
// vercel-bootstrap.php
$tmpPath = '/tmp';
$storagePath = "$tmpPath/storage";

// Crear directorios necesarios
$dirs = [
    "$storagePath/framework/views",
    "$storagePath/framework/cache/data",
    "$storagePath/framework/sessions",
    "$storagePath/logs",
    "$tmpPath/bootstrap/cache"
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}