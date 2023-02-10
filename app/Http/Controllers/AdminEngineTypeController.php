<?php

namespace App\Http\Controllers;

use App\Models\CarPart;
use App\Models\EngineType;
use App\Models\GermanDismantler;
use Illuminate\Http\Request;

class AdminEngineTypeController extends Controller
{
    public function index(Request $request): mixed
    {
        $completed = $request->query('completed');

        $engineTypes = EngineType::has('carParts')
            ->has('germanDismantlers')
            ->withCount('carParts')
            ->with('germanDismantlers')
            ->withCount('germanDismantlers');

        $totalEngineTypes = EngineType::count();

        $totalEngineTypesWithCarPartsAndKba = EngineType::has('carParts')
            ->has('germanDismantlers')
            ->count();

        $totalConnectedEngineTypesCount = EngineType::has('carParts')
            ->has('germanDismantlers')
            ->whereNotNull('connection_completed_at')
            ->count();

        $totalUnconnectedEngineTypesCount = EngineType::has('carParts')
            ->has('germanDismantlers')
            ->whereNull('connection_completed_at')
            ->count();


        if($completed) {
            $engineTypes = $engineTypes->whereNotNull('connection_completed_at');
        } else {
            $engineTypes = $engineTypes->whereNull('connection_completed_at');
        }

        $engineTypes = $engineTypes->paginate(25);

        $totalKbaConnected = GermanDismantler::has('engineTypes')->count();
        $totalCarPartsConnected = CarPart::has('engineType')->count();

        return view('admin.engine-types.index', compact(
            'engineTypes',
            'totalEngineTypes',
            'totalEngineTypesWithCarPartsAndKba',
            'totalKbaConnected',
            'totalCarPartsConnected',
            'totalConnectedEngineTypesCount',
            'totalUnconnectedEngineTypesCount',
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

    public function update(EngineType $engineType, Request $request): mixed
    {
        $completed = $request->get('completed');

        if($completed === 'incomplete') {
            $engineType->update(['connection_completed_at' => null]);
        } else if($completed === 'complete'){
            $engineType->update(['connection_completed_at' => now()]);
        }

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
