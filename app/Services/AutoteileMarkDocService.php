<?php

namespace App\Services;

use App\Models\NewCarPart;

class AutoteileMarkDocService
{
    public function generateExportCSV(NewCarPart $carPart): void
    {
        $path = base_path('public/exports/import.csv');
        $file = fopen($path, 'a');

        if (empty(file_get_contents($path))) {
            // Available fields
            $header = [
                'cat_id',
                'article_nr',
                'oe',
                'title',
                'description',
                'brand',
                'kba',
                'part_state',
                'quantity',
                'vat',
                'price',
                'price_b2b',
                'delivery',
                'delivery_time',
                'properties',
                'img_1',
                'img_2',
                'img_3',
                'img_4',
                'img_5',
                'img_6',
            ];

            fputcsv($file, $header, '|');
        }

        $partInformation = $this->resolvePartInformation($carPart);

        fputcsv($file, $partInformation, '|');
    }

    private function resolvePartInformation(NewCarPart $carPart): array
    {
        $kba = $carPart->my_kba->map(function ($kbaNumber) {
            return [
                'hsn' => $kbaNumber->hsn,
                'tsn' => $kbaNumber->tsn,
            ];
        })->toArray();

        $formattedPart = [
            'cat_id' => $this->resolveCategoryId($carPart),
            'article_nr' => $carPart->article_nr,
            'oe' => $carPart->original_number, // 'oe_nr' is the same as 'original_number
            'title' => $carPart->name,
            'description' => $this->resolveDescription($carPart),
            'brand' => $carPart->sbrCode?->ditoNumbers?->first()->brand ?? '',
            'kba' => $this->kbaArrayToString($kba),
            'part_state' => '2',
            'quantity' => '1',
            'vat' => '0',
            'price' => $carPart->new_price,
            'price_b2b' => $carPart->new_price,
            'delivery' => '0',
            'delivery_time' => $carPart->dismantle_company_name === 'F' ? '7-10' : '3-6',
            'properties' => $this->resolveProperties($carPart),
        ];

        $formattedImages = $this->resolveImages($carPart->carPartImages);

        return array_merge($formattedPart, $formattedImages);
    }

    private function resolveCategoryId(NewCarPart $carPart)
    {
        return $carPart->carPartType->germanCarPartTypes->first()->autoteile_markt_category_id;
    }

    /*
     * Resolve the properties of the car part with a coma separated string
     */

    public function resolveDescription(NewCarPart $carPart): string
    {

        $kba = $carPart->my_kba->map(function ($kbaNumber) {
            return [
                'hsn' => $kbaNumber->hsn,
                'tsn' => $kbaNumber->tsn,
            ];
        })->toArray();

        $kbaString = $this->kbaArrayToString($kba);

        $engineType = $carPart->engine_type ?? '';

        $description = "
            Lagernummer: $carPart->article_nr \n
            Originale Ersatzteilnummer: $carPart->original_number \n
            Motor Kennung: $carPart->full_engine_code \n
            Motortype: $engineType \n
            Brandstofftype: $carPart->fuel \n
            Getriebe: $carPart->gearbox \n
            Laufleistung: $carPart->mileage_km(km) \n
            Fahrgestellnummer: $carPart->vin \n
            Baujahr: $carPart->model_year \n
            Kbas: $kbaString \n
        ";

        return $description;
    }

    private function kbaArrayToString(array $kbaArray): string
    {
        $propertiesArray = array_map(function ($kbaNumber) {
            return $kbaNumber['hsn'] . $kbaNumber['tsn'];
        }, $kbaArray);

        return implode(',', $propertiesArray);
    }

    private function resolveProperties(NewCarPart $carPart): string
    {
        $engineCode = str_replace(',', '.', $carPart->engine_code);
        $engineType = str_replace(',', '.', $carPart->engine_type);
        $gearbox = str_replace(',', '.', $carPart->gearbox);
        $mileage = str_replace(',', '.', $carPart->mileage_km);
        $quality = str_replace(',', '.', $carPart->quality);

        return "MOTORCODE,{$engineCode},MOTORTYPE,{$engineType},GEARBOXCODE,{$gearbox},MILEAGE,{$mileage},QUALITY,{$quality}";
    }

    private function resolveImages($images): array
    {
        $formattedImages = [];

        if($images->count() === 0) {
           $formattedImages["img_0"] = 'http://46.101.206.99/storage/img/car-part/placeholder.jpg';
        }

        foreach ($images as $index => $image) {
            $url = asset("storage/img/car-part/{$image->new_car_part_id}/{$image->image_name}");

            $formattedImages["img_$index"] = $url;
        }

        return $formattedImages;
    }
}
