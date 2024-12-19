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

    public function getAllCategories(): JsonResponse
    {
        $categories = MainCategory::with('carPartTypes')->get();

        return response()->json($categories);
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
