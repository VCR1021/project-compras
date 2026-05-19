<?php

/*
|--------------------------------------------------------------------------
| Vercel Serverless Optimization Setup
|--------------------------------------------------------------------------
*/

// Asegura que Laravel use el directorio temporal /tmp para compilar vistas de Blade en Vercel
if (env('VIEW_COMPILED_PATH') === null) {
    config(['view.compiled' => '/tmp/storage/framework/views']);
}

// Asegura el almacenamiento de sesiones en entornos de solo lectura
if (config('session.driver') === 'file') {
    config(['session.driver' => 'cookie']);
}
