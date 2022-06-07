<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GermanDismantler;

class GetUniqueManufacturerPlaintextController extends Controller
{
    public function __invoke()
    {
        $plainTexts = GermanDismantler::select('manufacturer_plaintext')
            ->distinct()
            ->get();

        return $plainTexts;
    }
}
