<?php

namespace App\Actions\Parts;

use App\Models\CarPartType;
use App\Models\GermanDismantler;
use App\Actions\Parts\SortPartsAction;

class SearchByKbaAction
{
    public function execute(
        string $hsn,
        string $tsn,
        CarPartType $type = null,
        string $sort = null,
        int $paginate = null
    ): array
    {
        $germanDismantler = GermanDismantler::where('hsn', $hsn)
            ->where('tsn', $tsn)
            ->first();

        if (!$germanDismantler) {
            return [
                'success' => false,
                'message' => "KBA not found, if you are sure it's typed correctly please contact us to let us know we are missing the KBA",
            ];
        }

        $partsQuery = $germanDismantler->newCarParts()
            ->whereHas('carPartType', function ($query) use ($type) {
                if ($type) {
                    $query->where('id', $type->id);
                }
            })
            ->with('carPartImages');

        // Apply sorting
        $partsQuery = (new SortPartsAction())->execute($partsQuery, $sort);

        $parts = is_null($paginate)
            ? $partsQuery->get()
            : $partsQuery->paginate($paginate);

        if (!$parts) {
            return [
                'success' => false,
                'message' => "No parts found matching the KBA",
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
