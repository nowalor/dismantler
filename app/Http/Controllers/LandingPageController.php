<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    
    public function returnLandingPage() {
        return view('landingPage');
    }

    public function __invoke()//: View
    {

        $models = CarModel::all();
        $brands = CarBrand::all();

            return view('landingPage', compact('models', 'brands'));
    }

}
