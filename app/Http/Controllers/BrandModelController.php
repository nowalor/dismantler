<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use Illuminate\View\View;
use App\Models\DitoNumber;

class BrandModelController extends Controller
{
      /**
     * showModels(): Retrieves a brand by its slug and fetches models (DitoNumbers)
     * that have related car parts. Passes the brand and its models to the models view.
     *
     * @param string $slug The slug identifier for the brand.
     * @return View the models view for the given brand.
     */
    public function index(CarBrand $brand): View
    {
        $models = DitoNumber::where('producer', $brand->name)
            ->whereHas('sbrCodes.carParts') // Ensure models have related car parts
            ->get();

        return view('components.brands.models', compact('brand', 'models'));
    }
}
