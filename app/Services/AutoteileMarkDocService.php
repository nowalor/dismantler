<?php

namespace App\Services;

use App\Models\NewCarPart;

class AutoteileMarkDocService
{
    private ResolveKbaFromSbrCodeService $resolveKbaFromSbrCodeService;

    public function __construct()
    {
        $this->resolveKbaFromSbrCodeService = new ResolveKbaFromSbrCodeService();
    }

    public function generateExportCSV(NewCarPart $carPart)
    {
        $path = base_path('public/exports/import.csv');
        $file = fopen($path, 'w');

        // Available fields
        $header = [
            'cat_id',
            'article_nr',
            'title',
            'description',
            'brand',
            'kba',
            'part_state',
            'quantity',
            'vat',
            'price',
            'price_b2b',
            'img_1',
            'img_2',
            'img_3',
            'img_4',
            'img_5',
            'img_6',
        ];

        fputcsv($file, $header, '|');

        $partInformation = $this->resolvePartInformation($carPart);

        fputcsv($file, $partInformation, '|');
    }

    private function resolvePartInformation(NewCarPart $carPart): array
    {
        $kba = $this->resolveKbaFromSbrCodeService->resolve($carPart->sbr_car_code, $carPart->engine_code);
        $formattedPart = [
            'cat_id' => $this->resolveCategoryId($carPart),
            'article_nr' => $carPart->article_nr,
            'title' => $carPart->name,
            'description' => $this->resolveDescription($carPart),
            'brand' => $carPart->sbrCode->ditoNumbers->first()->brand,
            'kba' => $this->kbaArrayToString($kba),
            'part_state' => '2',
            'quantity' => '1',
            'vat' => '19',
            'price' => $carPart->price * 1.19,
            'price_b2b' => $carPart->price * 1.19,
        ];

        $formattedImages = $this->resolveImages($carPart->carPartImages);

        return array_merge($formattedPart, $formattedImages);
    }

    private function resolveCategoryId(NewCarPart $carPart)
    {
        return $carPart->carPartType->germanCarPartTypes->first()->autoteile_markt_category_id;
    }

    public function resolveDescription(NewCarPart $carPart): string
    {
        $description = "
            Lagernummer: $carPart->article_nr \n
            Originale Ersatzteilnummer: $carPart->original_number \n
            Preis: $carPart->price(€) Preis inklusive Versand und MwSt \n
            Motor Kennung: $carPart->engine_code \n
            Motortype: $carPart->engine_type \n
            Brandstofftype: $carPart->fuel \n
            Getriebe: $carPart->gearbox \n
            Laufleistung: $carPart->mileage_km(km) \n
            Fahrgestellnummer: $carPart->vin \n
            Baujahr: $carPart->model_year \n
            Kbas: {$this->kbaArrayToString(
             $this->resolveKbaFromSbrCodeService->resolve($carPart->sbr_car_code, $carPart->engine_code)
             )}
        ";

        return $description;
    }

    private function kbaArrayToString(array $kbaArray): string
    {
        return implode(',', $kbaArray);
    }

    private function resolveImages($images): array
    {
        $formattedImages = [];

        foreach ($images as $index => $image) {
            $url = asset("storage/img/car-part/{$image->new_car_part_id}/{$image->image_name}");

            $formattedImages["img_$index"] = $url;
        }

        return $formattedImages;
    }
}
