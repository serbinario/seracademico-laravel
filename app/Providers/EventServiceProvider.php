<?php

namespace Seracademico\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Seracademico\Events\DebitoStored;
use Seracademico\Events\DebitoUpdated;
use Seracademico\Listeners\ContaBancariaAdicionarBalanco;
use Seracademico\Listeners\ContaBancariaEditarBalaco;
use Seracademico\Listeners\GerarCarneGnet;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Seracademico\Events\SomeEvent' => [
            'Seracademico\Listeners\EventListener',
        ],
        DebitoStored::class => [
            ContaBancariaAdicionarBalanco::class,
            GerarCarneGnet::class
        ],
        DebitoUpdated::class => [
            ContaBancariaEditarBalaco::class
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);
    }
}
