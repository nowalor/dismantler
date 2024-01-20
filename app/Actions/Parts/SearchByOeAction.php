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
        string $oe,
        string $paginate = null,
    ): array
    {
        $partsQuery = NewCarPart::where('original_number', $oe);

        $parts = is_null($paginate) ? $partsQuery->get() : $partsQuery->paginate($paginate);

        return [
            'data' => [
                'parts' => $parts,
            ],
        ];
    }
}
