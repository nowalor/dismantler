<?php

use App\Models\NewCarPart;
use Illuminate\Database\Eloquent\Collection;

class GetOptimalPartsAction
{
    public function execute(string $oem): Collection
    {
        $cheapestPart = NewCarPart::where('oem', $oem)->sortBy('');
    }
}
