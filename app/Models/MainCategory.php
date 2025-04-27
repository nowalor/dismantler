<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NewCarPart;
use App\Models\CarPartType;

class MainCategory extends Model
{

    use HasFactory;
    
    /**
     * The many-to-many relationship with CarPartType.
     */
    public function carPartTypes()
    {
        return $this->belongsToMany(CarPartType::class, 'main_category_car_part_type');
    }

    /**
     * Get all main category names.
     */
    public static function allMainCategoryNames()
    {
        return self::pluck('name');
    }

    /**
     * Local query scope to load the count of new car parts (only parts not sold)
     * that are related through the carPartTypes relationship.
     *
     * Usage in controller:
     *   $mainCategories = MainCategory::withPartsCount()->get();
     */
    public function scopeWithPartsCount($query)
    {
        return $query->withCount([
            'carPartTypes as new_car_parts_count' => function ($q) {
                $q->join('new_car_parts', 'car_part_types.id', '=', 'new_car_parts.car_part_type_id')
                  ->whereNull('new_car_parts.sold_at');
            }
        ]);
    }
}
