<?php

namespace Subbe\WaveApp;

use Illuminate\Support\ServiceProvider;

class WaveAppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/waveapp.php' => config_path('waveapp.php'),
        ], 'config');
    }

    public function register()
    {
        $this->app->bind('waveapp', function () {
            return new WaveApp();
        });

        $this->mergeConfigFrom(__DIR__.'/../config/waveapp.php', 'waveapp');
    }
}
