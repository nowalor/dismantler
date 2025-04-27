<?php

namespace App\Http\Controllers;

use App\Models\CarPartType;
use App\Models\CarBrand;
use Illuminate\Support\Facades\Cache;

class BaseController extends Controller
{
    public $partTypes;
    public $carBrands;

    public function __construct()
    {
        $this->partTypes = Cache::remember('car_part_types', 3600, function () {
            return CarPartType::all();
        });

        $this->carBrands = Cache::remember('car_brands', 3600, function () {
            return CarBrand::all();
        });

        view()->share([
            'partTypes' => $this->partTypes,
            'carBrands' => $this->carBrands,
        ]);
    }

}
