<?php

namespace App\Actions\Parts;

use App\Models\NewCarPart;
use Illuminate\Database\Eloquent\Collection;

class SearchByOeAction
{
    /*
     * Search for a part by Original number[OE]
     */
    public function execute(
        ?string $oem,
        ?string $engine_code,
        ?string $gearbox,
        ?string $paginate = null,
    ): array
    {

        $partsQuery = NewCarPart::query();

        if(!empty($oem)) {
            $partsQuery = NewCarPart::where('original_number', $oem); 
        }

        if (!empty($engine_code)) {
            $partsQuery = $partsQuery->where('engine_code', $engine_code);
        }

        if(!empty($gearbox)) {
            $partsQuery = $partsQuery->where('gearbox', $gearbox);
        }

        $parts = is_null($paginate) ? $partsQuery->get() : $partsQuery->paginate($paginate);

        return [
            'data' => [
                'parts' => $parts,
            ],
        ];
    }
}
