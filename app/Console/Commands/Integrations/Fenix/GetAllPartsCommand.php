<?php

namespace App\Console\Commands\Integrations\Fenix;

use App\Integration\FenixClientInterface;
use Illuminate\Console\Command;

class GetAllPartsCommand extends Command
{
    protected $signature = 'fenix:get-all-parts';

    public function handle(): int
    {
        $parts = $this->client()->getAllParts('A', );

        logger($parts);
        foreach($parts as $part) {

        }

        return Command::SUCCESS;

    }

    private function client(): FenixClientInterface
    {
        return resolve(FenixClientInterface::class, [
            'apiUrl' => config('services.fenix_api.base_uri'),
            'username' => config('services.fenix_api.email'),
            'password' => config('services.fenix_api.password'),
        ]);
    }
}
