<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use App\Models\DismantleCompany;
use Illuminate\Routing\Controller as LaravelController;
use Illuminate\Support\Facades\Cache;
use App\Models\CarPartType;
use App\Models\MainCategory;

class BaseController extends LaravelController
{
    protected array $sharedData = [];

    public function __construct()
    {
        $this->sharedData['carPartTypes'] = Cache::remember('car_part_types', 86400, function () {
            return CarPartType::all();
        });

        $this->sharedData['mainCategories'] = Cache::remember('main_categories', 86400, function () {
            return MainCategory::all();
        });

        $this->sharedData['carBrands'] = Cache::remember('car_brands', 86400, function () {
            return CarBrand::all();
        });

        $this->sharedData['dismantleCompanies'] = Cache::remember('dismantle_companies', 86400, function () {
            return DismantleCompany::all();
        });

        $this->sharedData['mainCategoriesWithParts'] = Cache::remember('main_categories_with_parts', 86400, function () {
            return MainCategory::with('carPartTypes')->get();
        });

        // You can share with all views automatically if you want
        view()->share($this->sharedData);
    }
}
