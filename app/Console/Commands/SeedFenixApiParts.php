<?php

namespace App\Console\Commands;

use App\Console\Commands\Base\FenixApiBaseCommand;
use App\Models\SwedishCarPartType;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SeedFenixApiParts extends FenixApiBaseCommand
{
    protected $signature = 'fenixapi:seed';

    protected $description = 'Command description';

    public function handle()
    {
        // Configuration
        ini_set('max_execution_time', 50000000);
        ini_set('max_input_time', 50000000);

        $this->authenticate();

        $swedishCarPartTypes = SwedishCarPartType::all();

//        foreach($swedishCarPartTypes as $swedishCarPartType) {
//
//        }

        return Command::SUCCESS;
    }
}
