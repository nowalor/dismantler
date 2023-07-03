<?php

namespace App\Http\Controllers;

use App\Models\NewCarPart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminExportPartsController extends Controller
{
    public function index()
    {
        $carParts = NewCarPart::with('carPartImages')
            ->paginate(40);

        foreach ($carParts as $carPart) {
            $engineCode = $carPart->engine_code;

            $germanDismantlers = [];
            $carPart->sbrCode->ditoNumbers->each( function ($ditoNumber) use(&$germanDismantlers){
                array_push($germanDismantlers, $ditoNumber->germanDismantlers);
            });

            $germanDismantlers = array_unique($germanDismantlers);

            $carPart->kba = $germanDismantlers;
            $carPart->kba_string = implode(', ', array_map(function ($germanDismantler) {
                return implode([
                    'hsn' => $germanDismantler[0]->hsn,
                    'tsn' => $germanDismantler[0]->tsn,
                ]);
            }, $germanDismantlers));
        }

        return view('admin.export-parts.index', compact('carParts'));
    }
}
