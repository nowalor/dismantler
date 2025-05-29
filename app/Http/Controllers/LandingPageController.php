<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\CarBrand;
use App\Models\CarPartType;
use App\Models\ManufacturerText;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\DitoNumber;
use App\Models\MainCategory;
use App\Models\NewCarPart;
use Illuminate\Support\Str;


class LandingPageController extends BaseController
{

    /**
     * __invoke(): fetches all partTypes, brands and mainCategories and
     * passes them to ("/") - landingpage, so we can show brands and categories
     * @param // doesnt need any parameters but we still pass brands and categories as we need them
     * @return compact() we return an associative array with given elements
     */
    public function __invoke(): View
    {
        // quick question when code reviewed
        /* $brands = CarBrand::withCount('carParts')
            ->having('car_parts_count', '>', 0)
            ->get(); */

        $plainTexts = $this->sharedData['mainCategories'];

        $partTypes = $this->sharedData['carPartTypes'];

        $brands = $this->sharedData['carBrands'];


        $mainCategories = Cache::remember('main_categories_with_parts_count', 86400, function () {
            return MainCategory::select('main_categories.*')
                ->leftJoin('main_category_car_part_type', 'main_categories.id', '=', 'main_category_car_part_type.main_category_id')
                ->leftJoin('car_part_types', 'main_category_car_part_type.car_part_type_id', '=', 'car_part_types.id')
                ->leftJoin('new_car_parts', function ($join) {
                    $join->on('car_part_types.id', '=', 'new_car_parts.car_part_type_id')
                        ->whereNull('new_car_parts.sold_at');
                })
                ->groupBy('main_categories.id')
                ->selectRaw('count(new_car_parts.id) as new_car_parts_count')
                ->get();
        });

        // Get the current locale
        $locale = LaravelLocalization::getCurrentLocale();

        $recentBlogs = Blog::where('language', $locale)
            ->where('published_at', '<=', now())
            ->latest()
            ->get();

        // Fetch the logo configuration for the locale
        $logoConfig = config("logos.{$locale}");

        // Handle case where configuration is missing or incorrect
        if (!$logoConfig || !isset($logoConfig['path'])) {
            abort(500, "Logo configuration missing for locale: {$locale}");
        }

        // Extract only the path for the view
        $logoPath = $logoConfig['path'];

        return view('landingPage', compact('brands', 'plainTexts', 'partTypes', 'logoPath', 'mainCategories', 'recentBlogs'));
    }

}
