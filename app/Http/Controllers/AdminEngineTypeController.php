<?php

namespace App\Http\Controllers;

use App\Models\CarPart;
use App\Models\EngineType;
use App\Models\GermanDismantler;
use Illuminate\Http\Request;

class AdminEngineTypeController extends Controller
{
    public function index(): mixed
    {
        $engineTypes = EngineType::has('carParts')
            ->has('germanDismantlers')
            ->withCount('carParts')
            ->with('germanDismantlers')
            ->withCount('germanDismantlers')
            ->paginate(25);

        $totalKbaConnected = GermanDismantler::has('engineTypes')->count();
        $totalCarPartsConnected = CarPart::has('engineType')->count();

        return view('admin.engine-types.index', compact(
            'engineTypes',
            'totalKbaConnected',
            'totalCarPartsConnected',
        ));
    }

    public function show(EngineType $engineType): mixed
    {
        $engineType->load('germanDismantlers')->loadCount('carParts');

        $kbaMaxWat = $engineType
           ->germanDismantlers->pluck('max_net_power_in_kw')
           ->unique()
           ->toArray();

        /* $suggestedDismantlers = CarPart::where('engine_type_id', $engineType->id)
            ->whereNotNull('dito_number_id')
            ->has('ditoNumber.germanDismantlers')
            ->with('ditoNumber.germanDismantlers')
            ->get()
            ->pluck('ditoNumber.germanDismantlers')
            ->flatten()
            ->unique('id')
            ->values(); */



        $germanDismantlers = GermanDismantler::query();

        return view('admin.engine-types.show', compact('engineType', 'kbaMaxWat'));
    }

    public function update(EngineType $engineType): mixed
    {
        $engineType->update(['connection_completed_at' => now()]);

        return redirect()->back()->with('success', 'Connection completed');
    }

    public function destroy(EngineType $engineType, GermanDismantler $germanDismantler): mixed
    {
        if(!$germanDismantler->id) {
            return redirect()->back()->with('error', 'KBA not found');
        }

        $engineType->germanDismantlers()->detach($germanDismantler);

        return redirect()->back()->with('success', 'KBA disconnected');
    }

    public function destroyMultiple(EngineType $engineType, Request $request): mixed
    {
        $engineType->germanDismantlers()->detach($request->get('selected_kba'));

        return redirect()->back()->with('success', 'KBA disconnected');
    }

    public function destroyAllWithoutMaxWat(EngineType $engineType, Request $request): mixed
    {
        $maxWat = $request->get('max_wat');


        $idsToDetach = $engineType->germanDismantlers()
            ->where('max_net_power_in_kw', '!=', (int)$maxWat)
            ->pluck('id');

        $engineType->germanDismantlers()->detach($idsToDetach);

        return redirect()->back()->with('success', 'KBA disconnected');
    }
}
