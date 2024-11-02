<?php

namespace App\Console\Commands\Fenix;

use App\Actions\FenixAPI\Parts\GetPartsAction;
use App\Actions\FenixAPI\SaveFenixPartInDbAction;
use App\Models\NewCarPart;
use App\Services\FenixApiService;
use Illuminate\Console\Command;

class AddNewPartsCommand extends Command
{
    protected $signature = 'fenix:add-new-parts {sub_days?}';

    public function handle(): int
    {
        $subDays = $this->argument('sub_days');

        if(!$subDays) {
            $createdAt = now()->subDays(1)->format('Y-m-d');
        } else {
            $createdAt = now()->subDays((int)$subDays)->format('Y-m-d');
        }

        $dismantleCompanies = [
            'w',
            'p',
            'a',
            'bo',
            'f',
            'n',
            'al',
            's',
            'gb',
            'li',
            'd',
            'vi',
            'h',
            'as',

        ];

        // Probably gonna need to batch this soon...
        $filters = [
            "SbrPartCode" => [
                "7201",
                "7280",
                "7704",
                "7705",
                "7706",
                "7868",
                "7860",
                "7070",
                "7145",
                "7143",
                "7302",
                 "7816",
                 "3230",
                 "7255",
                 "7295",
                 "7393",
                 "7411",
                 "7700",
                 "7835",
                "3135",
                "1020",
                "1021",
                "1022",
                "4638",
                "3235",
                "3245",
                "4573",
                "7050",
                "7051",
                "7052",
                "7070",
               "7475",
            "7645",
            "3220",
            "7468",
            "7082",
            "4626",
            "7470",
            "7487"
            ],
            "CarBreaker" => $dismantleCompanies,
        ];

        $response = (new GetPartsAction())->execute(
            filters: $filters,
            createdDate: $createdAt,
        );

        if (!$response) {
            return Command::FAILURE;
        }

        $parts = $response['Parts'];

        foreach($parts as $part) {
            (new SaveFenixPartInDbAction())->execute($part);
        }

        return Command::SUCCESS;
    }
}
