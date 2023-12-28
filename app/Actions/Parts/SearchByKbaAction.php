<?php

namespace App\Actions\Parts;

use App\Models\CarPartType;
use App\Models\GermanDismantler;

class SearchByKbaAction
{
    /*
     * Search for a part by KBA
     * Can also parse a "type" to make the search more concise
     */
    public function execute(
        string      $hsn,
        string      $tsn,
        CarPartType $type = null,
        int $paginate = null,
    ): array
    {
        $germanDismantler = GermanDismantler::where('hsn', $hsn)
            ->where('tsn', $tsn)
            ->first();

        if (!$germanDismantler) {
            return [
                'success' => false,
                'message' => "Kba not found, if you are sure it's typed correctly please contact us to let us know we are missing the kba",
            ];
        }

        $partsQuery = $germanDismantler->newCarParts()
            ->whereHas('carPartType', function ($query) use ($type) {
                if ($type) {
                    $query->where('id', $type->id);
                }
            })
            ->with('carPartImages');

        $parts = is_null($paginate)
            ? $partsQuery->get()
            : $partsQuery->paginate($paginate)->withQueryString();


        if (!$parts) {
            return [
                'success' => false,
                'message' => "No parts found matching the kba",
            ];
        }

        return [
            'success' => true,
            'data' => [
                'parts' => $parts,
                'kba' => $germanDismantler,
            ],
        ];
    }
}
