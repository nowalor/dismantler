<?php

namespace App\Console\Commands\Integrations\Fenix;

use Illuminate\Console\Command;
use App\Enums\FenixDismantlerEnum;
use App\Integration\Fenix\FenixClientInterface;
use App\Integration\Fenix\Actions\SaveFenixDtoInDbAction;

class GetAllPartsCommand extends Command
{
    protected $signature = 'fenix:get-all-parts';

    public function handle(): int
    {

        // TODO, figure out how to call this on a schedule for every dismantler, with propper from and to dates to make sure we get all the parts...
   /*     foreach(FenixDismantlerEnum::cases() as $dismantlerCode) {*/
            $parts = $this->client()->getAllParts('A');

            foreach ($parts as $part) {
                (new SaveFenixDtoInDbAction)->execute($part);
            }
        /*}*/
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
