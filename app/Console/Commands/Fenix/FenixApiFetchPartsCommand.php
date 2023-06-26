<?php

namespace App\Console\Commands\Fenix;

use App\Console\Commands\Base\FenixApiBaseCommand;
use App\Models\CarPartImage;
use App\Models\NewCarPart;
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

        $sbrPartTypeCodes = SwedishCarPartType::select('code')
            ->get()
            ->pluck('code')
            ->toArray();

        $sbrPartTypeCodes = ['7201'];

        foreach ($sbrPartTypeCodes as $sbrPartTypeCode) {
            $data = $this->getParts($sbrPartTypeCode);
           // logger($data);

            $partsFormattedForInsert = $this->formatPartsForInsert($data['parts']);

            $this->uploadParts($partsFormattedForInsert);

//            $this->uploadImages($data['Parts']);

            // TODO handle pagination
        }

        return Command::SUCCESS;
    }

    private function formatPartsForInsert(array $parts): array
    {
        $formattedParts = [];

            foreach($parts[0] as $test) {
                $formattedParts[] = $this->formatPart($test);
            }


        return $formattedParts;
    }

    private function formatPart(array $part): array
    {
        $newPart = [
            'original_id' => $part['Id'],
           // 'external_dismantle_company_id' => $part['ArticleNumberAtCarbreaker'], // We don't get this information but we get the name
            'price' => $part['Price'] / 5,
            'data_provider_id' => 1,
            'sbr_part_code' => $part['SbrPartCode'],
            'sbr_car_code' => $part['SbrCarCode'],
            'original_number' => $part['OriginalNumber'],
            'quality' => $part['Quality'],
            'dismantled_at' => $part['DismantlingDate'],
        ];

        return $newPart;
    }

    private function uploadParts(array $parts)
    {
        foreach($parts as $part) {
            NewCarPart::updateOrCreate(['original_id' => $part['original_id']], $part);
        }
    }

    private function uploadImages(array $parts)
    {
        foreach($parts as $part) {
            $this->uploadImage($part['Images']);
        }
    }

    private function uploadImage(array $images)
    {
        $formattedImages = array_map(function ($image) {
            return [
                'car_part_id' => $image['car_part_id'],
                'origin_url' => $image['Url'],
                'image_with_our_logo_url' => $image['Url'],
            ];
        }, $images);

        CarPartImage::insert($formattedImages);
    }
}
