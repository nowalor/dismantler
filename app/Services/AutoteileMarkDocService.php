<?php

namespace App\Services;

use App\Models\NewCarPart;
use Illuminate\Support\Facades\Storage;

class AutoteileMarkDocService
{
    private ResolveKbaFromSbrCodeService $resolveKbaFromSbrCodeService;
    private CalculatePriceService $calculatePriceService;
    public function __construct()

    {
        $this->resolveKbaFromSbrCodeService = new ResolveKbaFromSbrCodeService();
        $this->calculatePriceService = new CalculatePriceService();
    }

    public function generateExportCSV(NewCarPart $carPart): void
    {
        $path = base_path('public/exports/import.csv');
        $file = fopen($path, 'a');

        if (empty(file_get_contents($path))) {
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

        // Upload to FTP server
        Storage::disk('ftp')->put('import.csv', file_get_contents(base_path('public/exports/import.csv')));
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
            'vat' => '0',
            'price' => $this->calculatePriceService
                ->sekToEurForFenix(
                    $carPart->price_sek,
                    $carPart->car_part_type_id
                ),
            'price_b2b' => $this->calculatePriceService
                ->sekToEurForFenix(
                    $carPart->price_sek,
                    $carPart->car_part_type_id
                ),
            'delivery' => '0',
            'delivery_time' => '3-6',
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
        $description = "
            Lagernummer: $carPart->article_nr \n
            Originale Ersatzteilnummer: $carPart->original_number \n
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

        foreach ($images as $index => $image) {
            $url = asset("storage/img/car-part/{$image->new_car_part_id}/{$image->image_name}");

            $formattedImages["img_$index"] = $url;
        }

        return $formattedImages;
    }
}
