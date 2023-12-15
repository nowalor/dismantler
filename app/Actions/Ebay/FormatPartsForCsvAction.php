<?php

namespace App\Actions\Ebay;

use App\Models\NewCarPart;
use Illuminate\Database\Eloquent\Collection;

class FormatPartsForCsvAction
{
    public function execute(Collection $parts)
    {

        foreach($parts as $part) {

        }
    }

    private function formatPart(NewCarPart $part)
    {
        return [
            ''
        ];
    }
}
