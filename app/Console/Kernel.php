<?php

namespace Seracademico\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \Seracademico\Console\Commands\Inspire::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->call(function () {
            # Enviando o email de geração do boleto
            \Mail::send('emailteste', [],
                function ($email) {
                    $email->from('enviar@alpha.rec.br', 'Alpha');
                    $email->subject('Inscrição Cuso Técnico Faculdade Alpha');
                    $email->to('fabinhobarreto2@gmail.com', 'Alpha Educação e Treinamentos');
                });
        })->everyMinute();
    }
}
