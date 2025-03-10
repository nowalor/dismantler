<?php

namespace App\Http\Controllers;

use App\Models\CarPartType;
use Illuminate\Http\Request;
use App\Models\MainCategory;
use Illuminate\Http\JsonResponse;

class ViewCarPartTypesController extends Controller
{
    public function index(MainCategory $mainCategory): JsonResponse
    {
        return response()->json($mainCategory->carPartTypes); // Fetch subcategories (car_part_types) related to the main category
    }

    /* public function getAllCategories(): JsonResponse
    {
        $categories = MainCategory::with('carPartTypes')->get();

        return response()->json($categories);
    } */

    // In ViewCarPartTypesController
    public function getAllCategories(): JsonResponse
    {
        $categories = MainCategory::with('carPartTypes')->get();

        // Transform the data to return `translated_name` instead of the raw `name`
        $localizedData = $categories->map(function ($mainCat) {
            return [
                'id' => $mainCat->id,
                // Use the translation key to get the localized name
                // e.g. __("main-categories.exhaust_system") => "Udstødningssystem"
                'translated_name' => __('main-categories.' . $mainCat->translation_key),

                // Now map the car part types
                'car_part_types' => $mainCat->carPartTypes->map(function ($subCat) {
                    return [
                        'id' => $subCat->id,
                        // e.g. __("car-part-types.Engine") => "Motor"
                        'translated_name' => __('car-part-types.' . $subCat->translation_key),
                    ];
                }),
            ];
        });

        return response()->json($localizedData);
    }

    public function getMainCategoryNames(): JsonResponse
    {
        $mainCategoryNames = MainCategory::allMainCategoryNames();

        return response()->json($mainCategoryNames);
    }

    // sub categories is just car_part_types // CarPartType
    public function getSubCategoryNames(): JsonResponse
    {
        $subCategoryNames = CarPartType::allPartTypeNames();

        return response()->json($subCategoryNames);
    }
}
