<?php


namespace Subbe\WaveApp;

use Illuminate\Support\ServiceProvider;

class WaveAppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/waveapp.php' => config_path('waveapp.php'),
        ]);
    }

    public function register()
    {
        parent::register();
    }
}
