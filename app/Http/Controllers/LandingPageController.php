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
use App\Models\NewCarPart;
use Illuminate\Support\Str;

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

        $mainCategories = MainCategory::withPartsCount()->get();

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

        return view('landingPage', compact('brands', 'plainTexts', 'partTypes', 'logoPath', 'mainCategories'));
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

    public function showSubCategories($name, $id)
    {
        $mainCategory = MainCategory::with('carPartTypes')->findOrFail($id);

        return view('categories.subcategories', compact('mainCategory'));
    }

    public function showBrandsForSubCategories($name, $id)
    {
        // Retrieve the sub-category (for URL/slug validation if needed)
        $subCategory = CarPartType::findOrFail($id);

        // Retrieve all car brands (no filtering)
        $brands = CarBrand::all();

        return view('subcategories.brands', compact('subCategory', 'brands'));
    }

    public function showModelsForSubCategoryAndBrand($subCategoryName, $subCategoryId, $brandName, $brandId)
    {
        $subCategory = CarPartType::where('id', $subCategoryId)->where('name', $subCategoryName)->firstOrFail();
        $brand = CarBrand::where('id', $brandId)->where('name', $brandName)->firstOrFail();

        $models = DitoNumber::where('producer', $brand->name)
            ->whereHas('sbrCodes.carParts', function ($query) use ($subCategoryId) {
                $query->where('car_part_type_id', $subCategoryId);
            })
            ->get();

        return view('subcategories.brands.models', compact('subCategory', 'brand', 'models'));
    }

    public function searchCarParts($subCategoryName, $subCategoryId, $brandName, $brandId, $modelName, $modelId)
    {
        $subCategory = CarPartType::where('id', $subCategoryId)->where('name', $subCategoryName)->firstOrFail();
        $brand = CarBrand::where('id', $brandId)->where('name', $brandName)->firstOrFail();
        $model = DitoNumber::where('id', $modelId)->where('new_name', $modelName)->firstOrFail();

        $carParts = NewCarPart::where('car_part_type_id', $subCategoryId)
            ->whereHas('sbrCode', function ($query) use ($modelId) {
                $query->where('dito_number_id', $modelId);
            })
            ->get();

        return view('subcategories.brands.models.search', compact('subCategory', 'brand', 'model', 'carParts'));
    }
}
