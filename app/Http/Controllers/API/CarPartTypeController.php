<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CarPartType;
use Illuminate\Http\Request;

class CarPartTypeController extends Controller
{
    public function __invoke()
    {
        $carPartTypes = CarPartType::with(['germanCarPartTypes'])->all();

        return response()->json($carPartTypes);
    }
}
