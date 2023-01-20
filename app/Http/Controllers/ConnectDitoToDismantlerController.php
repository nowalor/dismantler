<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DitoNumberGermanDismantler;
use App\Models\GermanDismantler;
use App\Models\DitoNumber;


class ConnectDitoToDismantlerController extends Controller
{
    public function connect($ditoNumberId, Request $request)
    {
        foreach($request->get('kba-checkbox') as $dismantlerId) {
            DitoNumberGermanDismantler::create([
                        'dito_number_id' => $ditoNumberId,
                        'german_dismantler_id' => $dismantlerId,
                    ]);
        }

        return redirect()->back()->with('success', 'Connection saved to database');
    }

    public function delete(DitoNumber $ditoNumber, GermanDismantler $germanDismantler)
    {
        DitoNumberGermanDismantler::where(
            [
                ['dito_number_id', '=',$ditoNumber->id],
                ['german_dismantler_id', '=',$germanDismantler->id],
            ]
        )->delete();

        return redirect()->back()->with('removed', 'Connection removed from database');
    }
}
