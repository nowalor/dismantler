<?php

namespace App\Actions\Parts;

use App\Models\CarBrand;
use App\Models\CarPartType;
use App\Models\DitoNumber;

class SearchByModelAction
{
    public function execute(
        DitoNumber $model,
        CarPartType $type = null,
        string $sort = null,
        int $paginate = null,
        array $filters = [] // New parameter for filters
    ): array {
        $sbr = $model->sbrCodes()->first();
        $partQuery = $sbr->carParts();

        if ($type) {
            $partQuery->where('car_part_type_id', $type->id);
        }

        foreach ($filters as $key => $value) {
            switch ($key) {
                case 'original_number':
                    $partQuery->where('original_number', 'LIKE', "%{$value}%");
                    break;
                case 'article_nr':
                    $partQuery->where('article_nr', 'LIKE', "%{$value}%");
                    break;
                case 'engine_type':
                    $partQuery->where('engine_type', 'LIKE', "%{$value}%");
                    break;
                case 'gearbox':
                    $partQuery->where(function ($query) use ($value) {
                        $query->where('subgroup', 'LIKE', "%{$value}%")
                              ->orWhere('gearbox', 'LIKE', "%{$value}%");
                    });
                    break;
            }
        }

        // Sort based on query parameter
        if ($sort) {
            switch ($sort) {
                case 'mileage_asc':
                    $partQuery->orderBy('mileage_km', 'asc');
                    break;
                case 'mileage_desc':
                    $partQuery->orderBy('mileage_km', 'desc');
                    break;
                case 'model_year_asc':
                    $partQuery->orderBy('model_year', 'asc');
                    break;
                case 'model_year_desc':
                    $partQuery->orderBy('model_year', 'desc');
                    break;
                case 'quality_asc':
                    $partQuery->orderBy('quality', 'asc');
                    break;
                case 'quality_desc':
                    $partQuery->orderBy('quality', 'desc');
                    break;
                case 'price_asc':
                    $partQuery->orderBy('price_sek', 'asc');
                    break;
                case 'price_desc':
                    $partQuery->orderBy('price_sek', 'desc');
                    break;
            }
        }

        $parts = is_null($paginate)
            ? $partQuery->get()
            : $partQuery->paginate($paginate)->withQueryString();

        return [
            'success' => true,
            'data' => [
                'parts' => $parts,
            ],
        ];
    }
}
