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


        if ($request->get('kba_filter') === 'without_kba') {
            $carParts = $carParts->doesntHave('ditoNumber.germanDismantlers');
        } else if ($request->get('kba_filter') === 'with_kba') {
            $carParts->has('ditoNumber.germanDismantlers');
        } else if ($request->get('completion_filter') === 'completed') {
            $carParts = $carParts->whereRelation('ditoNumber', 'is_selection_completed', 1);
        } else if ($request->get('completion_filter') === 'uncompleted') {
            $carParts = $carParts->whereRelation('ditoNumber', 'is_selection_completed', 0);
        }

        $carParts = $carParts->paginate(20);


        return view('admin.new-car-parts.index', compact(
            'carParts',
            'totalCarParts',
            'totalCarPartsWithDitoNumber',
            'totalCarPartsWithoutDitoNumber',
            'totalCarPartsWithDitoNumberAndIsInteresting',
            'totalCarPartsWithKbaConnection',
            'totalCarPartsWithoutKbaConnection',
        ));
    }
}
