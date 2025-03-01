<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use App\Models\DitoNumber;
use Illuminate\Http\Request;
use App\Models\MainCategory;
use Illuminate\View\View;

/**
     * Display the main categories and their car part types for a given brand and model.
     *
     * @param CarBrand   $brand The car brand selected in the BrandModelController's index view.
     * @param DitoNumber $model We display all models for given brand, if they have car part types.
     *
     * @return View Returns the view displaying all fx models for given brand.
     */
class BrandModelCarPartTypeController extends Controller
{
    public function index(CarBrand $brand, DitoNumber $model): View
    {
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
}
