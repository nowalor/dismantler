<?php

namespace App\Actions\Parts;

use App\Models\NewCarPart;
use Illuminate\Database\Eloquent\Collection;

class GetOptimalPartsAction
{
    public function execute(string $oem, array $includedIn = []): Collection
    {
        $cheapestPartQuery = NewCarPart::where('original_number', $oem)
            ->whereIn('car_part_type_id', [1,2,3,4,5,6,7,8 ,9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20])
            ->orderBy('price_eur');

        $partWithBestMileageQuery = NewCarPart::where('original_number', $oem)
            ->where('mileage_km', '!=', 0)
            ->orderBy('mileage_km');

        if(!empty($includedIn)) {
            $cheapestPartQuery = $cheapestPartQuery->whereIn('id', $includedIn);
            $partWithBestMileageQuery = $partWithBestMileageQuery->whereIn('id', $includedIn);
        }

        $cheapestPart = $cheapestPartQuery->first();
        $partWithBestMileage = $partWithBestMileageQuery->first();

        $parts = new Collection();

        if($cheapestPart) {
            $parts->push($cheapestPart);
        }

        if($partWithBestMileage && $partWithBestMileage->id !== $cheapestPart->id) {
            $parts->push($partWithBestMileage);
        }

        return $parts;
    }
}
