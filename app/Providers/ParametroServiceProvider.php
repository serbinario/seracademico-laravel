<?php

namespace Seracademico\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Seracademico\Contracts\ReportAluno;
use Seracademico\Uteis\ParametroBanco;
use Seracademico\Uteis\ParametroMatricula;
use Seracademico\Uteis\ParametroVestibular;
use Seracademico\Uteis\ReportBuilderQuery\AlunoPosBuilderQueryForReport;

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
        App::bind('matricula', function() {
            return new ParametroMatricula();
        });

        # Retornando o objeto de Parametro do vestibular
        App::bind('vestibular', ParametroVestibular::class);

        # Retornando o objeto de Parametro do banco
        App::bind('banco', ParametroBanco::class);

        # Retorna um objeto AlunoPosBuilderQueryForReport pela interface ReportAluno
        App::bind(ReportAluno::class, AlunoPosBuilderQueryForReport::class);
    }
}
