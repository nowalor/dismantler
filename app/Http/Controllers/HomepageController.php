<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use App\Models\ManufacturerText;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomepageController extends Controller
{
    public function __invoke(): View
    {
        $brands = CarBrand::withCount('carParts')
            ->having('car_parts_count', '>', 0)
            ->get();

        $plainTexts = ManufacturerText::all();

        return view('homepage', compact('brands', 'plainTexts'));
    }
}
