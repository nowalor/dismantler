<?php

namespace App\Http\Controllers;
use App\Models\NewCarPart;
use Illuminate\Http\Request;

class CarPartFullviewController extends Controller
{
    
    public function index(NewCarPart $part) {
        return view('car-part-fullview', compact('part'));
    }
    

}
