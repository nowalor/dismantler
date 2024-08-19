<?php

namespace App\Actions\Parts;

use Illuminate\Database\Eloquent\Builder;

class SortPartsAction
{
    public function execute(Builder $query, ?string $sort): Builder
    {
        if ($sort) {
            switch ($sort) {
                case 'mileage_asc':
                    $query->orderBy('mileage_km', 'asc');
                    break;
                case 'mileage_desc':
                    $query->orderBy('mileage_km', 'desc');
                    break;
                case 'model_year_asc':
                    $query->orderBy('model_year', 'asc');
                    break;
                case 'model_year_desc':
                    $query->orderBy('model_year', 'desc');
                    break;
                case 'quality_asc':
                    $query->orderBy('quality', 'asc');
                    break;
                case 'quality_desc':
                    $query->orderBy('quality', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price_sek', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price_sek', 'desc');
                    break;
                default:
                    // Default sort (optional)
                    $query->orderBy('id', 'asc');
                    break;
            }
        }
        
        return $query;
    }
}
