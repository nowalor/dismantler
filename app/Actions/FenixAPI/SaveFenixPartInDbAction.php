<?php

namespace App\Actions\FenixAPI;

use App\Models\NewCarPart;
use App\Models\NewCarPartImage;

class SaveFenixPartInDbAction
{
    public function execute(array $part)
    {
        $formattedPart = $this->formatPart($part);

        $newPart = NewCarPart::firstOrCreate(
            ['original_id' => $formattedPart['original_id']],
            $formattedPart
        );

        if ($newPart->wasRecentlyCreated && $part['Images']) {
            $this->uploadImages($part['Images'], $newPart->id);
        }
    }

    private function formatPart(array $part): array
    {
        return [
            'original_id' => $part['Id'],
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
            'originally_created_at' => $part['CreatedDate'],
        ];
    }

    private function uploadImages(array $images, int $newCarPartId): void
    {
        foreach ($images as $image) {
            $formattedImage = $this->formatImage($image, $newCarPartId);

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
