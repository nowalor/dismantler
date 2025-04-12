<?php

namespace App\Integration\Fenix\Actions;

use App\Integration\Fenix\Types\FenixCarPart;
use App\Models\NewCarPart;
use App\Models\NewCarPartImage;

class SaveFenixDtoInDbAction
{
    public function execute(FenixCarPart $part): void
    {
        $newPart = NewCarPart::firstOrCreate(
            ['original_id' => $part->original_id],
            [
                'original_id' => $part->original_id,
                'price_sek' => $part->price_sek,
                'data_provider_id' => 1,
                'sbr_part_code' => $part->sbr_part_code,
                'sbr_car_code' => $part->sbr_car_code,
                'original_number' => $part->original_number,
                'quality' => $part->quality,
                'dismantled_at' => $part->dismantled_at,
                'engine_code' => $part->engine_code ?? null,
                'engine_type' => $part->engine_type ?? null,
                'dismantle_company_name' => $part->dismantle_company_name,
                'article_nr_at_dismantler' => $part->article_nr_at_dismantler,
                'sbr_car_name' => $part->sbr_car_name ?? null,
                'body_name' => $part->body_name ?? null,
                'fuel' => $part->fuel ?? null,
                'gearbox' => $part->gearbox ?? null,
                'warranty' => $part->warranty,
                'mileage_km' => (int)($part->mileage ?? 0) * 10,
                'mileage' => (int)($part->mileage ?? 0),
                'model_year' => $part->model_year ?? null,
                'vin' => $part->vin ?? null,
                'originally_created_at' => $part->original_created_at ?? null,
            ]
        );

        if (!$newPart->wasRecentlyCreated) {
            // Log or dump skipped ones for debugging
            logger('Skipped part (already existed): ' . $part->original_id);
        }


        if ($newPart->wasRecentlyCreated && !empty($part->images)) {
            $this->uploadImages($part->images, $newPart->id);
        }
    }

    private function uploadImages(array $images, int $newCarPartId): void
    {
        foreach ($images as $image) {
            NewCarPartImage::firstOrCreate(
                [
                    'new_car_part_id' => $newCarPartId,
                    'original_url' => $image['Url'],
                ],
                [
                    'new_car_part_id' => $newCarPartId,
                    'original_url' => $image['Url'],
                ]
            );
        }
    }
}
