<?php

namespace App\Actions\Parts;

use App\Models\NewCarPart;
use Illuminate\Database\Eloquent\Collection;
use App\Actions\Parts\SortPartsAction;

class SearchByOeAction
{
    public function execute(
        ?string $oem,
        ?string $engine_code,
        ?string $gearbox,
        ?string $search = null,
        ?string $sort = null,
        ?string $type_id = null, // Accept type_id
        ?int $paginate = null
    ): array {
        $partsQuery = NewCarPart::query();
    
        // Apply filters based on OEM, engine_code, and gearbox if provided
        if (!empty($oem)) {
            $partsQuery->where('original_number', $oem);
        }
    
        if (!empty($engine_code)) {
            $partsQuery->where('engine_code', $engine_code);
        }
    
        if (!empty($gearbox)) {
            $partsQuery->where('gearbox', $gearbox);
        }
    
        // Filter by type if type_id is provided
        if (!empty($type_id)) {
            $partsQuery->where('car_part_type_id', $type_id); // Assuming `car_part_type_id` is the relevant column
        }
    
        // Define the searchable columns
        $searchableColumns = [
            'id', 'new_name', 'quality', 'original_number',
            'article_nr', 'mileage_km', 'model_year',
            'engine_type', 'fuel', 'price_sek', 'sbr_car_name'
        ];
    
        // Apply the search term across the defined searchable columns
        if (!empty($search)) {
            $partsQuery->where(function ($query) use ($search, $searchableColumns) {
                foreach ($searchableColumns as $column) {
                    $query->orWhere($column, 'LIKE', "%{$search}%");
                }
            });
        }
    
        // Apply sorting if necessary
        $partsQuery = (new SortPartsAction())->execute($partsQuery, $sort);
    
        // Paginate results if pagination is provided, otherwise get all results
        $parts = is_null($paginate) ? $partsQuery->get() : $partsQuery->paginate($paginate);
    
        return [
            'data' => [
                'parts' => $parts,
            ],
        ];
    }
    
    
    
}
