<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function __invoke()
    {
        $brands = CarBrand::all();

        return view('homepage', compact('brands'));
    }
}
