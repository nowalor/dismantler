<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\DitoNumberGermanDismantler;
use App\Models\GermanDismantler;
use App\Models\DitoNumber;


class ConnectDitoToDismantlerController extends Controller
{
    public function connect($ditoNumberId, Request $request)
    {
        foreach ($request->get('kba-checkbox') as $dismantlerId) {
            DitoNumberGermanDismantler::create([
                'dito_number_id' => $ditoNumberId,
                'german_dismantler_id' => $dismantlerId,
            ]);
        }

        return redirect()->back()->with('success', 'Connection saved to database');
    }

    public function deleteMultiple(DitoNumber $ditoNumber, Request $request)
    {
        $key = $request->get('key');
        $value = $request->get('value');

        $kbaToRemove = $ditoNumber->germanDismantlers()->where($key, '!=', $value)->pluck('id');
        DitoNumberGermanDismantler::where('dito_number_id', $ditoNumber->id)->whereIn('german_dismantler_id', $kbaToRemove)->delete();

        return redirect()->back()->with('removed', 'Connections removed from database');
    }

    public function delete(DitoNumber $ditoNumber, GermanDismantler $germanDismantler)
    {
        DitoNumberGermanDismantler::where(
            [
                ['dito_number_id', '=', $ditoNumber->id],
                ['german_dismantler_id', '=', $germanDismantler->id],
            ]
        )->delete();

        return redirect()->back()->with('removed', 'Connection removed from database');
    }

    public function deleteExceptSelected(DitoNumber $ditoNumber, Request $request)
    {
        if (!$request->get('select-status')) {
            return redirect()->back()->with('removed', 'Please select at least one checkbox');
        }

        $selectStatus = $request->get('select-status');

        if ($selectStatus === 'selected') {
            $kbaToRemove = $ditoNumber->germanDismantlers()->whereIn('id', $request->get('kba_check'))->pluck('id');
        } else {
            $kbaToRemove = $ditoNumber->germanDismantlers()->whereNotIn('id', $request->get('kba_check'))->pluck('id');
        }
        // $ditoNumber->germanDismantlers()->detach($kbaToRemove);
        DitoNumberGermanDismantler::where('dito_number_id', $ditoNumber->id)->whereIn('german_dismantler_id', $kbaToRemove)->delete();


        return redirect()->back()->with('removed', $kbaToRemove);
    }

    public function restore(DitoNumber $ditoNumber, Request $request)// : RedirectResponse
    {
        return $kbaToRemove = $request->get('kba_ids');

        return DitoNumberGermanDismantler::withTrashed()
            ->where('dito_number_id', $ditoNumber->id)
            ->whereIn('german_dismantler_id', $kbaToRemove)
            ->get();

        return redirect()->back()->with('restored', 'Connection restored');
    }
}
