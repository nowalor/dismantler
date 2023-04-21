<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GermanDismantler;

class GetUniqueManufacturerPlaintextController extends Controller
{
    public function __invoke()
    {
        $plainTexts = GermanDismantler::select(['id', 'hsn', 'tsn','manufacturer_plaintext'])
//            ->distinct()
                ->where('manufacturer_plaintext', 'like', '%audi%')
            ->get();

        return $plainTexts;
    }
}
