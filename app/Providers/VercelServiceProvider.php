<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VercelServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (config('app.env') === 'production') {
            $targetPath = '/tmp/storage/framework/views';
            
            if (!is_dir($targetPath)) {
                mkdir($targetPath, 0755, true);
            }

            // Forzar el contenedor de servicios a registrar las vistas y sesiones en caliente
            config(['view.compiled' => $targetPath]);
            config(['session.driver' => 'cookie']);
        }
    }

    public function boot(): void
    {
        //
    }
}
