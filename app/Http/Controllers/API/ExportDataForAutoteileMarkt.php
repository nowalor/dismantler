<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CarPart;
use App\Models\DitoNumber;
use Illuminate\Http\Request;

class ExportDataForAutoteileMarkt extends Controller
{
    public function __invoke()
    {
        $ditoNumbers = DitoNumber::where('producer', 'audi')->take(100)->get()->pluck('id');

        $carParts = CarPart::whereIn('dito_number_id', $ditoNumbers)
            ->with('carPartImages')
            ->whereNot('price1', 0)
            ->take(10)
            ->get();


        foreach ($carParts as $carPart) {
            $germanDismantlers = $carPart->ditoNumber()->with('germanDismantlers', function ($query) use ($carPart) {
                $engineName = $carPart->engine_code;

                $query->whereHas('engineTypes', function ($query) use ($engineName) {
                    $query->where('name', $engineName);
                });

            })->get()->pluck('germanDismantlers')->flatten(1)->toArray();

            $kbas = array_map(function ($germanDismantler) {
                return $germanDismantler['hsn'] . $germanDismantler['tsn'];
            }, $germanDismantlers);

            $carPart->kba = $kbas;
            $carPart->brand = $carPart->ditoNumber->producer;
        }

        $carParts = array_filter($carParts->toArray(), function($carPart) {
            return count($carPart['kba']) > 0;
        });


        return $this->exportToCsv($carParts);
//         return $carParts;
    }

    private function exportToCsv(array $parts)
    {
        $path = base_path('public/exports/output.csv');
        $file = fopen($path, 'w');

        // Available fields
        $header = [
            'article_nr',
            'title',
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

        fputcsv($file, $header);

        $partsFormatted = array_map(function ($part) {
            $data = [];
            $images = count($part['car_part_images']) ?
                $this->getImages($part['car_part_images']) :
                [];

            $partInformation = [
                'article_nr' => 'TODO',
                'title' => $part['name'],
                'brand' => $part['brand'],
                'kba' => implode(',', $part['kba']),
                'part_state' => 2, // used
                'quantity' => $part['quantity'],
                'vat' => 'TODO',
                'price' => $this->getPrice($part['price1']),
                'price_b2b' => $part['price1'],
            ];

            return array_merge($partInformation, $images);
        }, $parts);


        foreach ($partsFormatted as $part) {
            fputcsv($file, $part);
        }

        fclose($file);

        return $partsFormatted;
    }

    private function getImages(array $images): array
    {
        $newImages = [
            'img_1' => '',
            'img_2' => '',
            'img_3' => '',
            'img_4' => '',
            'img_5' => '',
            'img_6' => '',
        ];
        foreach ($images as $index => $image) {
            $newImages['img_' . ($index + 1)] = $image['origin_url'];
        }

        return $newImages;
    }

    private function getPrice(int $price): float
    {
        $partPrice = (float)($price / 75) * 1.2;

        $deliveryPrice = 150 * 1.19;

        return $partPrice + $deliveryPrice;
    }
}
