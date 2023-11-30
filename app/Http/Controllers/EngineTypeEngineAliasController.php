<?php

namespace App\Http\Controllers;

use App\Models\EngineAlias;
use App\Models\EngineType;

class EngineTypeEngineAliasController extends Controller
{
    public function __invoke()
    {
        $engineTypes = EngineType::where('is_new_format', true)
            ->with('engineAliases')
            ->get();

        return response()->json($engineTypes);
    }
}
