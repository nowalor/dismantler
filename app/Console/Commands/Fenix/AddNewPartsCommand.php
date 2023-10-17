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
            "bo",
            'F',
            'A',
            'N',
        ];

        $filters = [
            "SbrPartCode" => ["7201", "7280", "7704", "7705", "7706", "7868", "7860", "7070", "7145"],
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
