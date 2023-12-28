<?php

namespace App\Actions\Parts;

use App\Models\CarPartType;
use App\Models\GermanDismantler;
use App\Models\NewCarPart;

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
        $parts = NewCarPart::where('original_number', $oe);

    }
}
