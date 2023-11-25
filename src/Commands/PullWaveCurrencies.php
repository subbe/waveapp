<?php

namespace Jeffgreco13\Wave\Commands;

use Jeffgreco13\Wave\Wave;
use Illuminate\Console\Command;

class PullWaveCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wave:pull-currencies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will fetch the available currencies from Wave and save them in a json file in this storage path.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $wave = new Wave();
        if ($currencies = data_get($wave->currencies(),'data.currencies',false)){
            file_put_contents(storage_path('wave_currencies.json'),json_encode($currencies));
        }
    }
}
