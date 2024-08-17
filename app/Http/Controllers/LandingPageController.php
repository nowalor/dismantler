<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use App\Models\CarPartType;
use App\Models\ManufacturerText;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    
    public function __invoke(): View
    {
        $brands = CarBrand::withCount('carParts')
            ->having('car_parts_count', '>', 0)
            ->get();

        $plainTexts = ManufacturerText::all();

        $partTypes = CarPartType::all();

        return view('landingPage', compact('brands', 'plainTexts', 'partTypes'));
    }

}
