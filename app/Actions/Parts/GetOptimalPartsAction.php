<?php

namespace App\Actions\Parts;

use App\Models\NewCarPart;
use Illuminate\Database\Eloquent\Collection;

class GetOptimalPartsAction
{
    public function execute(string $oem): Collection
    {
        $cheapestPart = NewCarPart::where('original_number', $oem)
            ->whereIn('car_part_type_id', [1,2,3,4,5,6,7])
            ->orderBy('price_eur')
            ->first();

        $partWithBestMileage = NewCarPart::where('original_number', $oem)->orderBy('mileage_km')->first();

        return Collection::make([
            $cheapestPart,
            $partWithBestMileage,
        ]);
    }
}
