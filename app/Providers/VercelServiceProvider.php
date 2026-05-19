<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\ViewServiceProvider;

class VercelServiceProvider extends ServiceProvider
{
    /**
     * Registra los servicios esenciales de la aplicación en Vercel.
     */
    public function register(): void
    {
        // 1. Configurar la carpeta temporal /tmp para la compilación de Blade
        $targetPath = '/tmp/storage/framework/views';
        if (!is_dir($targetPath)) {
            mkdir($targetPath, 0755, true);
        }
        config(['view.compiled' => $targetPath]);
        config(['session.driver' => 'cookie']);

        // 2. Forzar el registro manual del proveedor de vistas de Laravel
        if (!$this->app->bound('view')) {
            $this->app->register(ViewServiceProvider::class);
        }
    }

    /**
     * Ejecuta los servicios de arranque de la aplicación.
     */
    public function boot(): void
    {
        //
    }
}
