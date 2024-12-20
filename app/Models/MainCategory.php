<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{

    public function carPartTypes()
    {
        return $this->belongsToMany(CarPartType::class, 'main_category_car_part_type');
    }

    public static function allMainCategoryNames() {
        return self::pluck('name');
    }

}
