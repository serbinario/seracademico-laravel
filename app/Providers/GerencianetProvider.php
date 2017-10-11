<?php
namespace Seracademico\Providers;

use Illuminate\Support\ServiceProvider;
use Seracademico\Services\Financeiro\GerencianetService;

class GerencianetProvider extends ServiceProvider
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
        $this->app->singleton(GerencianetService::class, function ($app) {
            return new GerencianetService(
                env('GNET_CLIENT_TOKEN'),
                env('GNET_CLIENT_SECRET'),
                env('GNET_SENBOX'),// prod false,
                env('GNET_LINK')
            );
        });

        // Tokens Serbinario dev
        //'Client_Id_507f78b213cfddb82b3ad4fb62a8a0b2e52bec11',
        //'Client_Secret_81c1617105e56f177928f4d5a1bb59071268c740',


        /**
         * Token alpha teste
         *
         * client = Client_Id_9fe59c8f8bb524948e87f98dc6a1485808914498
         * secret = Client_Secret_a04c332d41981fff7e13573ff6e1a5d3b78b1098
         */

        // Tokens Alpha prod
        //'Client_Id_bdcedc61766a30f15d26dc8d7a8d515101afe8b4',
        //'Client_Secret_2e4c7c1e01afdef95f581fb283027686b73e4c37',
    }
}
