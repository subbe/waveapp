<?php

namespace Jeffgreco13\Wave;

use Illuminate\Support\ServiceProvider;
use Jeffgreco13\Wave\Commands\PullWaveCurrencies;

class WaveServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PullWaveCurrencies::class,
            ]);
        }

        $this->publishes([
            __DIR__.'/../config/wave.php' => config_path('wave.php'),
        ], 'config');
    }

    public function register()
    {
        $this->app->bind('laravel-wave', function () {
            return new Wave();
        });

        $this->mergeConfigFrom(__DIR__.'/../config/wave.php', 'laravel-wave');
    }
}
