<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchByPlateController extends Controller
{
    public function __invoke()
    {
        return view('searchByPlate');
    }
}
