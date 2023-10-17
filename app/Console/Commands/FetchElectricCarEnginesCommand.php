<?php

namespace App\Console\Commands;

use App\Actions\FenixAPI\Parts\GetPartsAction;
use App\Actions\FenixAPI\SaveFenixPartInDbAction;
use Illuminate\Console\Command;

class FetchElectricCarEnginesCommand extends Command
{
    protected $signature = 'fenix:fetch-electric';

    public function handle(): int
    {
        $dismantleCompanies = [
            "bo",
            'F',
            'A',
            'N',
        ];

        $filters = [
            "SbrPartCode" => ["7143", "7302"],
            "CarBreaker" => $dismantleCompanies,
        ];

        $response = (new GetPartsAction())->execute(
            filters: $filters,
        );

        $parts = $response['Parts'];

        foreach($parts as $part) {
            (new SaveFenixPartInDbAction())->execute($part);
        }

        return Command::SUCCESS;
    }
}
