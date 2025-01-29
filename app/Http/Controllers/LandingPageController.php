<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use App\Models\CarPartType;
use App\Models\ManufacturerText;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\DitoNumber;
use App\Models\MainCategory;

class LandingPageController extends Controller
{
    public function __invoke(): View
    {
        // quick question when code reviewed
        /* $brands = CarBrand::withCount('carParts')
            ->having('car_parts_count', '>', 0)
            ->get(); */

        $plainTexts = ManufacturerText::all();

        $partTypes = CarPartType::all();

        $brands = CarBrand::all();

        // Get the current locale
        $locale = LaravelLocalization::getCurrentLocale();

        // Fetch the logo configuration for the locale
        $logoConfig = config("logos.{$locale}");

        // Handle case where configuration is missing or incorrect
        if (!$logoConfig || !isset($logoConfig['path'])) {
            abort(500, "Logo configuration missing for locale: {$locale}");
        }

        // Extract only the path for the view
        $logoPath = $logoConfig['path'];

        return view('landingPage', compact('brands', 'plainTexts', 'partTypes', 'logoPath'));
    }

    public function showModels($slug)
    {
        $brand = CarBrand::where('slug', $slug)->firstOrFail();

        $models = DitoNumber::where('producer', $brand->name)
            ->whereHas('sbrCodes.carParts') // Ensure models have related car parts
            ->get();

        return view('brands.models', compact('brand', 'models'));
    }

    public function categoriesForBrandModel($slug, $modelId)
    {
        $brand = CarBrand::where('slug', $slug)->firstOrFail();

        // get the selected model (DitoNumber)
        $model = DitoNumber::findOrFail($modelId);

        // get all sbrCode IDs connected with this model
        $sbrIds = $model->sbrCodes()->pluck('id');

        // 4. Eager-load MainCategories with their CarPartTypes (subcategories)
        //    and count the parts that match the model's SbrCode IDs.
        $mainCategories = MainCategory::with([
            'carPartTypes' => function ($query) use ($sbrIds) {
                // Count how many parts each subcategory has for this model
                $query
                    ->withCount([
                        'carParts as part_count' => function ($subQuery) use ($sbrIds) {
                            $subQuery->whereIn('sbr_code_id', $sbrIds);
                        },
                    ])
                    // Eager-load the actual parts for each subcategory,
                    // filtered by the model's sbr_code IDs
                    ->with([
                        'carParts' => function ($subQuery) use ($sbrIds) {
                            $subQuery->whereIn('sbr_code_id', $sbrIds);
                        },
                    ]);
            },
        ])->get();

        return view('brands.categories', compact('brand', 'model', 'mainCategories'));
    }
}
