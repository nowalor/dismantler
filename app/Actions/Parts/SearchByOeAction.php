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
    ): Collection
    {
        $partsQuery = NewCarPart::where('original_number', $oe);

        if($paginate) {
            return $partsQuery->paginate($partsQuery);
        }

        return $partsQuery->get();
    }
}
