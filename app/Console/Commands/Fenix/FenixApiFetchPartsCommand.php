<?php

namespace App\Console\Commands\Fenix;

use App\Console\Commands\Base\FenixApiBaseCommand;
use App\Models\CarPartImage;
use App\Models\NewCarPart;
use App\Models\NewCarPartImage;
use App\Models\SwedishCarPartType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FenixApiFetchPartsCommand extends FenixApiBaseCommand
{
    protected $signature = 'fenix:fetch';

    protected $description = 'Command description';

    public function handle(): int
    {
        // Configuration
        ini_set('max_execution_time', 50000000);
        ini_set('max_input_time', 50000000);

        $this->authenticate();

        $dismantleCompanies = [
            'LI',
            'D'
        ];


        foreach ($dismantleCompanies as $dismantleCompany) {
            $data = $this->getParts($dismantleCompany);

            $this->uploadParts($data['parts']);
        }

        return Command::SUCCESS;
    }

    private function uploadParts(array $parts): void
    {
        foreach ($parts as $part) {
            $formattedPart = $this->formatPart($part);

            $newPart = NewCarPart::updateOrCreate(['original_id' => $formattedPart['original_id']], $formattedPart);

            $this->uploadImages($part['Images'], $newPart->id);
        }
    }

    private function formatPart(array $part): array
    {
        $newPart = [
            'original_id' => $part['Id'],
            // 'external_dismantle_company_id' => $part['ArticleNumberAtCarbreaker'], // We don't get this information but we get the name
            'price_sek' => $part['Price'],
            'data_provider_id' => 1,
            'sbr_part_code' => $part['SbrPartCode'],
            'sbr_car_code' => $part['SbrCarCode'],
            'original_number' => $part['OriginalNumber'],
            'quality' => $part['Quality'],
            'dismantled_at' => $part['DismantlingDate'],
            'engine_code' => $part['Car']['EngineCode1'],
            'engine_type' => $part['Car']['EngineType'],
            'dismantle_company_name' => $part['CarBreaker'],
            'article_nr_at_dismantler' => $part['ArticleNumberAtCarbreaker'],
            'sbr_car_name' => $part['Car']['SbrCarName'],
            'body_name' => $part['Car']['BodyName'],
            'fuel' => $part['Car']['Fuel'],
            'gearbox' => $part['Car']['Gearbox'],
            'warranty' => $part['Warranty'],
            'mileage_km' => (int)$part['Car']['Mileage'] * 10,
            'model_year' => $part['Car']['ModelYear'],
            'vin' => $part['Car']['VIN'],
        ];

        return $newPart;
    }

    private function uploadImages(array $images, int $newCarPartId)
    {
        foreach ($images as $image) {
            $formattedImage = $this->formatImage($image, $newCarPartId);

            $newImage =
                NewCarPartImage::firstOrCreate(
                    [
                        'new_car_part_id' => $newCarPartId,
                        'original_url' => $formattedImage['original_url']
                    ], $formattedImage
                );
        }
    }

    private function formatImage(array $image, int $carPartId): array
    {
        return [
            'new_car_part_id' => $carPartId,
            'original_url' => $image['Url'],
        ];
    }
}
