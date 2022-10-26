<?php

namespace CageA80\FedEx;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('fedex-rest', function () {
            $config = $this->app['config']->get('fedex-rest');;

            return new FedEx($config);
        });
    }

    public function boot()
    {
        $configPath = __DIR__.'/../../config/fedex-rest.php';
        $this->publishes([$configPath => $this->app->configPath('fedex-rest.php')], 'config');
    }
}
