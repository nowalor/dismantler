<?php

namespace App\Http\Controllers;

use App\Models\CarPart;
use App\Models\EngineType;
use Illuminate\Http\Request;

class MissingInformationController extends Controller
{
    public function __invoke()
    {
        $uniqueEngineCodesFromCarParts = CarPart::select('engine_code')
            ->where('engine_code', '!=', '')
            ->distinct()
            ->get()
            ->pluck('engine_code')
            ->toArray();

        $engineTypesFromDB = EngineType::select('name')
            ->distinct()
            ->get()
            ->pluck('name')
            ->toArray();

        // Create a array with all the uniqueEngineCodesFromCarParts


    }
}
