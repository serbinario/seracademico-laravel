<?php

namespace Seracademico\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Seracademico\Console\Commands\AtualizaTransacoesGerencianet;
use Seracademico\Console\Commands\SendEmailAlertaBiblioteca;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \Seracademico\Console\Commands\Inspire::class,
        SendEmailAlertaBiblioteca::class,
        AtualizaTransacoesGerencianet::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('send:emailalertabiblioteca')
            ->everyMinute();

    }
}
