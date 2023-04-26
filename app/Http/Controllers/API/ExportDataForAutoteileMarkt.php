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
        $ditoNumbers = DitoNumber::where('producer', 'audi')->take(2)->get()->pluck('id');

        $carParts = CarPart::whereIn('dito_number_id', $ditoNumbers)
            ->has('carPartImages')
            ->with('carPartImages')
            ->take(1000)
            ->get();

        foreach ($carParts as $carPart) {
            $germanDismantlers = $carPart->ditoNumber()->with('germanDismantlers', function($query) use($carPart) {
                $engineName = $carPart->engine_code;

                $query->whereHas('engineTypes', function($query) use($engineName) {
                    $query->where('name', $engineName);
                });

            })->get()->pluck('germanDismantlers')->flatten(1)->toArray();

            $kbas = array_map(function($germanDismantler) {
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

        fputcsv($file, $header);

        $partsFormatted = array_map(function($part) {
            $data = [];
            $images = $this->getImages($part['car_part_images']);

            $partInformation =  [
                'article_nr' => 'TODO',
                'title' => $part['name'],
                'description' => $part['comments'],
                'brand' => $part['brand'],
                'kba' => implode(',', $part['kba']),
                'part_state' => $part['condition'],
                'quantity' => $part['quantity'],
                'vat' => 'TODO',
                'price' => $part['price1'],
                'price_b2b' => $part['price1'],
            ];

            return array_merge($partInformation, $images);
        }, $parts);


        foreach($partsFormatted as $part) {
            fputcsv($file, $part);
        }

        fclose($file);

        return $partsFormatted;
    }

    private function getImages(array $images)
    {
        $newImages = [
            'img_1' => '',
            'img_2' => '',
            'img_3' => '',
            'img_4' => '',
            'img_5' => '',
            'img_6' => '',
        ];
        foreach($images as $index => $image) {
            $newImages['img_' . ($index + 1)] = $image['origin_url'];
        }

        return $newImages;
    }
}
