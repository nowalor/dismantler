<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\CarPartType;
use App\Models\CarBrand;
use App\Models\DitoNumber;

class SubcategoryController extends Controller
{
    /**
     * @param MainCategory object $mainCategory via route model binding
     * @queries for all car-part-types from the mainCategory relation
     * @return View Returns the view displaying the subcategories.
     */
    public function index(MainCategory $mainCategory): View
    {
        return view('components.categories.subcategories', compact('mainCategory'));
    }

    /**
     * @param CarPartType object $subCategory via route model binding
     * @queries for all related brands with given car part type
     * @return View Returns the view displaying brands for the sub-category.
     */
    public function showBrandsForSubcategories(CarPartType $subCategory): View
    {
        if (Str::slug($subCategory->name) !== $subCategory->slug) {
            abort(404, 'Sub-category name does not match.');
        }

        $brands = CarBrand::whereHas('ditoNumbers', function ($query) use ($subCategory) {
            $query->whereHas('sbrCodes.carParts', function ($q) use ($subCategory) {
                $q->where('car_part_type_id', $subCategory->id);
            });
        })->get();

        return view('subcategories.brands', compact('subCategory', 'brands'));
    }

    /**
     * @param CarPartType $subCategory
     * @param CarBrand $brand
     * @queries for car models which has the specific car part type(subcategory) and brand:
     * @return View
     */
    public function showModelsForSubCategoryAndBrand(CarPartType $subCategory, CarBrand $brand)
    {

        $models = DitoNumber::where('producer', $brand->name)
            ->whereHas('sbrCodes.carParts', function ($query) use ($subCategory) {
                $query->where('car_part_type_id', $subCategory->id);
            })
            ->get();

        return view('subcategories.brands.models', compact('subCategory', 'brand', 'models'));
    }
}
