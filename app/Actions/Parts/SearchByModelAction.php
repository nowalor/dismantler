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
        int $paginate = null,
    ): array
    {
        $sbr = $model->sbrCodes()->first();

        $partQuery = $sbr->carParts();

        if($type) {
            $partQuery->where('car_part_type_id', $type->id);
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
