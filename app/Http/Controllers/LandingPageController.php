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

    /**
     * showModels(): Retrieves a brand by its slug and fetches models (DitoNumbers)
     * that have related car parts. Passes the brand and its models to the models view.
     *
     * @param string $slug The slug identifier for the brand.
     * @return View the models view for the given brand.
     */
    public function showModels($slug)
    {
        $brand = CarBrand::where('slug', $slug)->firstOrFail();

        $models = DitoNumber::where('producer', $brand->name)
            ->whereHas('sbrCodes.carParts') // Ensure models have related car parts
            ->get();

        return view('components.brands.models', compact('brand', 'models'));
    }

    /**
     * categoriesForBrandModel(): Retrieves a brand by slug and a model (DitoNumber) by its ID.
     * It then gathers all sbrCodes associated with the model, eager-loads main categories with their
     * car part types (subcategories), counts the parts per subcategory based on the model's sbrCodes,
     * and passes the data to the categories view.
     *
     * @param string $slug The slug identifier for the brand.
     * @param int $modelId The ID of the model (DitoNumber).
     * @return View Returns the categories view for the given brand and model.
     */
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

        return view('components.brands.categories', compact('brand', 'model', 'mainCategories'));
    }

    /**
     * showSubCategories(): Retrieves a main category (with its car part types) by its ID
     * and passes it to the subcategories view.
     *
     * @param string $name The slug or name identifier for the main category.
     * @param int $id The ID of the main category.
     * @return View Returns the view displaying the subcategories.
     */
    public function showSubCategories($name, $id)
    {
        $mainCategory = MainCategory::with('carPartTypes')->findOrFail($id);

        return view('components.categories.subcategories', compact('mainCategory'));
    }

    /**
     * showBrandsForSubCategories(): Retrieves a sub-category (CarPartType) by its ID,
     * verifies the slug against its name, then retrieves brands that have at least one model
     * (DitoNumber) with related car parts in this sub-category. Passes the sub-category and
     * matching brands to the view.
     *
     * @param string $name The URL slug for the sub-category.
     * @param int $id The ID of the sub-category.
     * @return View Returns the view displaying brands for the sub-category.
     */
    public function showBrandsForSubCategories($name, $id)
    {
        // Retrieve the sub-category (CarPartType)
        $subCategory = CarPartType::findOrFail($id);

        // Optional: validate that the URL slug matches the sub-category name
        if (Str::slug($subCategory->name) !== $name) {
            abort(404, 'Sub-category name does not match.');
        }

        // Retrieve only those CarBrands that have at least one DitoNumber,
        // which in turn has an sbrCode with a car part of this sub-category.
        $brands = CarBrand::whereHas('ditoNumbers', function ($query) use ($id) {
            $query->whereHas('sbrCodes.carParts', function ($q) use ($id) {
                $q->where('car_part_type_id', $id);
            });
        })->get();

        return view('subcategories.brands', compact('subCategory', 'brands'));
    }

    /**
     * showModelsForSubCategoryAndBrand(): fetches all related models based on
     * mainCategory -> subCategory (car_part_types) -> all brands with given part type -> all models for that given brand with that car part type.
     * Retrieves a sub-category (car_part_types) and a brand by their IDs,
     * verifies the URL slugs against their names, then fetches models (DitoNumbers) for the brand
     * that have car parts in the specified sub-category. Passes the sub-category, brand, and models to the view.
     * @param string $subCategoryName The URL slug for the sub-category.
     * @param int $subCategoryId The ID of the sub-category.
     * @param string $brandName The URL slug for the brand.
     * @param int $brandId The ID of the brand.
     * @return View Returns the view displaying models for the sub-category and brand.
     */
    public function showModelsForSubCategoryAndBrand($subCategoryName, $subCategoryId, $brandName, $brandId)
    {

        $subCategory = CarPartType::findOrFail($subCategoryId);

        if (Str::slug($subCategory->name) !== $subCategoryName) {
            abort(404, 'Sub-category name does not match.');
        }

        $brand = CarBrand::findOrFail($brandId);

        if (Str::slug($brand->name) !== $brandName) {
            abort(404, 'Brand name does not match.');
        }

        $models = DitoNumber::where('producer', $brand->name)
            ->whereHas('sbrCodes.carParts', function ($query) use ($subCategoryId) {
                $query->where('car_part_type_id', $subCategoryId);
            })
            ->get();

        return view('subcategories.brands.models', compact('subCategory', 'brand', 'models'));
    }

}
