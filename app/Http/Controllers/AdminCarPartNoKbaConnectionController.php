<?php

namespace App\Http\Controllers;

use App\Models\CarPart;
use App\Models\DitoNumber;
use Illuminate\Http\Request;

class AdminCarPartNoKbaConnectionController extends Controller
{
    public function __invoke(Request $request)
    {
        $carParts = CarPart::has('ditoNumber')
            ->with('ditoNumber')
            ->whereRelation('ditoNumber', 'is_not_interesting', 0)
            ->with('dismantleCompany')
            ->with('carPartType');

        // Counters
        $totalCarParts = CarPart::count();
        $totalCarPartsWithDitoNumber = CarPart::has('ditoNumber')->count();
        $totalCarPartsWithoutDitoNumber = CarPart::doesntHave('ditoNumber')->count();
        $totalCarPartsWithDitoNumberAndIsInteresting = CarPart::has('ditoNumber')
            ->whereRelation('ditoNumber', 'is_not_interesting', 0)
            ->count();

        $totalCarPartsWithKbaConnection = CarPart::has('ditoNumber.germanDismantlers')->count();
        $totalCarPartsWithoutKbaConnection = CarPart::doesntHave('ditoNumber.germanDismantlers')->count();

        $totalPartsWithEngineType = CarPart::where('engine_code', '!=', '')->count();
        $totalPartsWithoutEngineType = CarPart::where('engine_code', '=', '')->count();
        $totalPartsWithUsableEngineType = CarPart::whereNotNull('engine_type_id')->count();


        /* if ($request->get('kba_filter') === 'without_kba') {
            $carParts = $carParts->doesntHave('ditoNumber.germanDismantlers');
        } else if ($request->get('kba_filter') === 'with_kba') {
            $carParts->has('ditoNumber.germanDismantlers');
        } else if ($request->get('completion_filter') === 'completed') {
            $carParts = $carParts->whereRelation('ditoNumber', 'is_selection_completed', 1);
        } else if ($request->get('completion_filter') === 'uncompleted') {
            $carParts = $carParts->whereRelation('ditoNumber', 'is_selection_completed', 0);
        }

        if($request->has('engine_type_filter')) {
            if($request->get('engine_type_filter') === 'without_engine_type') {
                $carParts = $carParts->whereNull('engine_type_id');
            } else {
                $carParts = $carParts->whereNotNull('engine_type_id');
            }
        } */

        // Marcus filter
        if($request->get('filter') === 'dito_number_no_kba_engine_type') {
            $carParts = $carParts->doesntHave('ditoNumber.germanDismantlers')
                ->where('engine_code', '!=', '');
        }

        $carParts = $carParts->paginate(20)->withQueryString();


        return view('admin.new-car-parts.index', compact(
            'carParts',
            'totalCarParts',
            'totalCarPartsWithDitoNumber',
            'totalCarPartsWithoutDitoNumber',
            'totalCarPartsWithDitoNumberAndIsInteresting',
            'totalCarPartsWithKbaConnection',
            'totalCarPartsWithoutKbaConnection',
            'totalPartsWithEngineType',
            'totalPartsWithoutEngineType',
            'totalPartsWithUsableEngineType',
        ));
    }
}
