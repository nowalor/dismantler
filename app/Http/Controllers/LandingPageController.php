<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use App\Models\CarPartType;
use App\Models\ManufacturerText;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\App;

class LandingPageController extends Controller
{

    public function __invoke(): View
    {
        $brands = CarBrand::withCount('carParts')
            ->having('car_parts_count', '>', 0)
            ->get();

        $plainTexts = ManufacturerText::all();

        $partTypes = CarPartType::all();

        // Get the current locale
        $locale = App::getLocale();

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

}
