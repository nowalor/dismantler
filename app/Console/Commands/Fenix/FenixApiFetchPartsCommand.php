<?php

namespace App\Console\Commands\Fenix;

use App\Console\Commands\Base\FenixApiBaseCommand;
use App\Models\CarPartImage;
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

            $partsFormattedForInsert = $this->formatPartsForInsert($data['Parts']);

            $this->uploadParts($partsFormattedForInsert);

            $this->uploadImages($data['Parts']);

            // TODO handle pagination
        }

        return Command::SUCCESS;
    }

    private function formatPartsForInsert(array $parts): array
    {
        $formattedParts = [];

        foreach ($parts as $part) {
            $formattedParts[] = $this->formatPart($part);
        }

        return $formattedParts;
    }

    private function formatPart(array $part): array
    {
        $newPart = [
            'original_id' => $part['Id'],
            'name' => 'MOTOR BENSIN', // TODO resolve
            'dismantle_company_id' => $part['ArticleNumberAtCarbreaker'],
            'quantity' => 1,
            'price' => $part['Price'] / 5,
        ];

        return $newPart;
    }

    private function uploadParts(array $parts)
    {
        DB::table('car_parts')->insert($parts);
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
