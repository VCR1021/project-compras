<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/*
|--------------------------------------------------------------------------
| Inyección Serverless de Emergencia para Vercel
|--------------------------------------------------------------------------
| Forzamos la redirección del compilador de vistas al directorio temporal 
| '/tmp' antes de que el contenedor de Laravel intente inicializarse.
*/
if (env('APP_ENV') === 'production') {
    $targetViewPath = '/tmp/storage/framework/views';
    if (!is_dir($targetViewPath)) {
        mkdir($targetViewPath, 0755, true);
    }
    // Forzar la configuración del contenedor en caliente
    config(['view.compiled' => $targetViewPath]);
    config(['session.driver' => 'cookie']);
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();