<?php

namespace Seracademico\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Seracademico\Uteis\ParametroMatricula;

class ParametroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        # Retornando o objeto de Parametro de matrícula
        App::bind('matricula', function()
        {
            return new ParametroMatricula();
        });
    }
}
