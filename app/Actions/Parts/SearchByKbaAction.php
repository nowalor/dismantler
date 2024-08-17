<?php

namespace App\Actions\Parts;

use App\Models\NewCarPart;
use Illuminate\Database\Eloquent\Collection;
use App\Actions\Parts\SortPartsAction;

class SearchByOeAction
{
    public function execute(
        ?string $oem,
        ?string $engine_code,
        ?string $gearbox,
        ?string $sort = null,
        ?int $paginate = null
    ): array
    {
        $partsQuery = NewCarPart::query();

        if (!empty($oem)) {
            $partsQuery->where('original_number', $oem); 
        }

        if (!empty($engine_code)) {
            $partsQuery->where('engine_code', $engine_code);
        }

        if (!empty($gearbox)) {
            $partsQuery->where('gearbox', $gearbox);
        }

        // Apply sorting
        $partsQuery = (new SortPartsAction())->execute($partsQuery, $sort);

        $parts = is_null($paginate) ? $partsQuery->get() : $partsQuery->paginate($paginate)();

        return [
            'data' => [
                'parts' => $parts,
            ],
        ];
    }
}
