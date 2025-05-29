<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\CarBrand;
use App\Models\CarPartType;
use App\Models\ManufacturerText;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\MainCategory;

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

        $recentBlogs = Blog::where('language', $locale)
            ->where('published_at', '<=', now())
            ->latest()
            ->get();

        // Fetch the logo configuration for the locale
        $logoConfig = config("logos.{$locale}");

        // Handle case where configuration is missing or incorrect
        if (!$logoConfig || !isset($logoConfig['path'])) {
            abort(500, "Logo configuration missing for locale: {$locale}");
        }

        // Extract only the path for the view
        $logoPath = $logoConfig['path'];

        return view('landingPage', compact('brands', 'plainTexts', 'partTypes', 'logoPath', 'mainCategories', 'recentBlogs'));
    }

}
