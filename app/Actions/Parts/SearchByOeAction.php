<?php

namespace App\Actions\Parts;

use App\Models\NewCarPart;
use App\Actions\Parts\SortPartsAction;
use Illuminate\Support\Facades\Log;

class SearchByOeAction
{
    public function execute(
        ?string $oem,
        ?string $engine_code,
        ?string $gearbox,
        ?string $search = null,
        ?string $sort = null,
        ?string $type_id = null,
        ?int $paginate = null
    ): array {
        $partsQuery = NewCarPart::query();

        if (!empty($oem)) {
            $partsQuery->where('original_number', 'LIKE', "%{$oem}%");
        }

        if (!empty($engine_code)) {
            $partsQuery->where('engine_code', 'LIKE', "%{$engine_code}%");
        }

        if (!empty($gearbox)) {
            $partsQuery->where('gearbox', 'LIKE', "%{$gearbox}%");
        }

        if (!empty($type_id)) {
            $partsQuery->where('car_part_type_id', $type_id);
        }

        $searchableColumns = [
            'id',
            'new_name',
            'quality',
            'original_number',
            'article_nr',
            'mileage_km',
            'model_year',
            'engine_type',
            'fuel',
            'price_sek',
            'sbr_car_name'
        ];

        // Revised search logic for independent keyword matching
        if (!empty($search)) {
            $searchTerms = preg_split('/\s+/', trim($search));
            $partsQuery->where(function ($query) use ($searchTerms, $searchableColumns) {
                foreach ($searchTerms as $term) {
                    $query->where(function ($subQuery) use ($term, $searchableColumns) {
                        foreach ($searchableColumns as $column) {
                            $subQuery->orWhere($column, 'LIKE', "%{$term}%");
                        }
                    });
                }
            });
        }

        $partsQuery = (new SortPartsAction())->execute($partsQuery, $sort);

        $parts = is_null($paginate) ? $partsQuery->get() : $partsQuery->paginate($paginate);

        return [
            'data' => [
                'parts' => $parts,
            ],
        ];
    }
}


