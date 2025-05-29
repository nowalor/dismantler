<?php

namespace App\Actions\Parts;

use App\Models\CarPartType;
use App\Models\GermanDismantler;
use App\Actions\Parts\SortPartsAction;

class SearchByKbaAction {
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
            ->whereNull('country')
            ->whereHas('carPartType', function ($query) use ($type) {
                if ($type) {
                    $query->where('id', $type->id);
                }
            })
            ->with([
                'carPartImages',
                'sbrCode',
                'ditoNumber',
                'carPartType'
            ]);

        // Convert BelongsToMany to Builder
        $partsQuery = $partsQuery->getQuery(); // Ensure this is the query builder

        // Apply sorting
        $partsQuery = (new SortPartsAction())->execute($partsQuery, $sort);

        // Ensure pagination is applied
        $paginate = $paginate ?? 10; // Default to 10 if paginate is null

        // Paginate the query, not the collection
        $parts = $partsQuery->simplePaginate($paginate); // This ensures pagination

        if ($parts->isEmpty()) {
            return [
                'success' => false,
                'message' => "No parts found matching the KBA",
            ];
        }

        return [
            'success' => true,
            'data' => [
                'parts' => $parts, // This is a paginator, not a collection
                'kba' => $germanDismantler,
            ],
        ];
    }

}
