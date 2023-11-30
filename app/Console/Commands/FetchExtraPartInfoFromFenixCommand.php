<?php

namespace App\Console\Commands;

use App\Actions\FenixAPI\Parts\GetPartsAction;
use App\Models\NewCarPart;
use Illuminate\Console\Command;

class FetchExtraPartInfoFromFenixCommand extends Command
{
    protected $signature = 'fenix:fetch-extra-part-info';


    public function handle(): string
    {
        $dismantleCompanies = [
            "bo",
            'F',
            'A',
            'N',
            'AL',
            'S',
            'N',
        ];

        foreach ($dismantleCompanies as $dismantleCompany) {
            $filters = [
                "SbrPartCode" => ["7201", "7280", "7704", "7705", "7706", "7868", "7860", "7070", "7145", "7143", "7302"],
                "CarBreaker" => [$dismantleCompany],
            ];

            // Get count of parts
            $response = (new GetPartsAction())->execute(
                filters: $filters,
                take: 1,
                action: 2,
            );

            // Handle pagination
            $partsCount = 0;
            $increment = 500;
            $totalParts = $response['Count'];
            $page = 1;

            while ($partsCount < $totalParts) {
                $response = (new GetPartsAction())->execute(
                    filters: $filters,
                    take: $increment,
                    skip: $partsCount,
                    page: $page,
                );

                foreach ($response['Parts'] as $part) {
                    $dbPart = NewCarPart::where('original_id', $part['Id'])->first();

                    if(!$dbPart) {
                        continue;
                    }

                    $dbPart->subgroup = $part['SubGroup'];
                    $dbPart->gearbox_nr = $part['Car']['GearboxNo'];
                    $dbPart->brand_name = $part['Car']['BrandName'];

                    $dbPart->save();
                }

                $partsCount += $increment;
                $page++;
            }
        }

        return Command::SUCCESS;
    }
}
