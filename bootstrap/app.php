<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        /*
         * =================================================================
         * 🌐 CONFIGURACIÓN PARA ENTORNO SERVERLESS (VERCEL)
         * =================================================================
         * Se configura 'trustProxies' en '*' para confiar en los balanceadores
         * de carga de Vercel. Esto evita bucles infinitos de redirección HTTPS
         * y asegura el correcto funcionamiento de las sesiones basadas en cookies.
         */
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();