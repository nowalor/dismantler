<?php

namespace App\Http\Controllers;

use App\Models\DitoNumber;
use App\Models\GermanDismantler;
use App\Models\ManufacturerText;
use App\Models\CommercialName;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminDitoNumbersController extends Controller
{

    public function index(Request $request)
    {
        $ditoNumbers = DitoNumber::withCount('carParts', 'germanDismantlers')
            ->whereIn('producer', [
                'Nissan' ,
                'Mazda',
                'Citroen',
                'Renault',
                'Peugeot',
                'Saab',
                'Ford',
                'Fiat',
                'BMW',
                'Honda',
            ]);

        $filter = $request->get('filter');
        if ($filter === 'uninteresting') {
            $ditoNumbers = $ditoNumbers->where('is_not_interesting', 1);
        } else {
            $ditoNumbers = $ditoNumbers->where('is_not_interesting', 0);
        }


        if ($filter === 'completed') {
            $ditoNumbers = $ditoNumbers->where('is_selection_completed', 1);
        } else {
            $ditoNumbers = $ditoNumbers->where('is_selection_completed', 0);

        }

//        if($request->has('kba_connection')) {
//            if($request->input('kba_connection') === 'has') {
//                $ditoNumbers = $ditoNumbers->has('germanDismantlers');
//            } else if ($request->input('kba_connection') === 'dont_have') {
//                $ditoNumbers = $ditoNumbers->doesntHave('germanDismantlers');
//            }
//        }

        /* Filter those that have / don't have a connection to a engine type */
//        if($request->has('engine_connection')) {
//            if($request->input('engine_connection') === 'has') {
//                $ditoNumbers = $ditoNumbers->has('germanDismantlers.engineTypes');
//            } else if ($request->input('engine_connection') === 'dont_have') {
//                $ditoNumbers = $ditoNumbers->doesntHave('germanDismantlers.engineTypes');
//            }
//        }

        if ($request->input('search')) {
            $ditoNumber = $ditoNumbers
                ->where(function ($query) use ($request) {
                    $query->where('producer', 'like', '%' . $request->input('search') . '%');
                    $query->orWhere('brand', 'like', '%' . $request->input('search') . '%');
                });
        }

        $ditoNumbers = $ditoNumbers->paginate(50)->withQueryString();

        // Counters
        $totalDitoNumbers = DitoNumber::count();
        $totalDitoNumbersWithKbaConnection = DitoNumber::has('germanDismantlers')->count();
        $totalDitoNumbersWithoutKbaConnection = DitoNumber::doesntHave('germanDismantlers')->count();
        $totalDitoNumbersWithEngineConnection = DitoNumber::has('germanDismantlers.engineTypes')->count();
        $totalDitoNumbersWithoutEngineConnection = DitoNumber::doesntHave('germanDismantlers.engineTypes')->count();
        // Total dito numbers with engine connection and kba connection and car parts
        $totalDitoNumbersWithEngineConnectionAndKbaConnectionAndCarParts = DitoNumber::has('germanDismantlers.engineTypes')
            ->has('germanDismantlers')
            ->has('carParts')
            ->withCount('germanDismantlers')
            ->withCount('carParts')
            ->get();

        // return $totalDitoNumbersWithEngineConnectionAndKbaConnectionAndCarParts;
        return view('admin.dito-numbers.index', compact(
            'ditoNumbers',
            'totalDitoNumbers',
            'totalDitoNumbersWithKbaConnection',
            'totalDitoNumbersWithoutKbaConnection',
            'totalDitoNumbersWithEngineConnection',
            'totalDitoNumbersWithoutEngineConnection',
            'totalDitoNumbersWithEngineConnectionAndKbaConnectionAndCarParts'
        ));

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(DitoNumber $ditoNumber, Request $request)
    {
        $uniqueMaxNet = GermanDismantler::select('max_net_power_in_kw')
            ->distinct()
            ->pluck('max_net_power_in_kw');

       $germanDismantlers = GermanDismantler::whereNotIn('id', function ($query) use ($ditoNumber) {
            $query->select('german_dismantler_id')
                ->from('dito_number_german_dismantler')
                ->where('dito_number_id', $ditoNumber->id);
        });

        if ($request->filled('sort_by')) {
            $germanDismantlers->orderBy($request->input('sort_by'));
        }

        if ($request->filled('date_from')) {
            $fromDate = Carbon::parse($request->input('date_from'));
            $germanDismantlers
                ->where('date_of_allotment', '>=', $fromDate);

        }

        if ($request->filled('date_to')) {
            $toDate = Carbon::parse($request->input('date_to'));
            $germanDismantlers
                ->where('date_of_allotment', '<=', $toDate);
        }

        if ($request->get('max_net') != 0) {
            $germanDismantlers->where('max_net_power_in_kw', $request->get('max_net'));
        }

        $plaintexts = ManufacturerText::all();
        $commercialNames = CommercialName::all();

        $relatedDismantlers = $ditoNumber->germanDismantlers()->paginate(500);

        if ($request->filled('plaintext')) {
            $germanDismantlers->where('manufacturer_plaintext', 'like', '%' . $request->input('plaintext') . '%');
        }

        if ($request->filled('commercial_name')) {
            $germanDismantlers->where(function ($query) use ($request) {
                $query->where('commercial_name', 'like', '%' . $request->input('commercial_name') . '%')
                    ->orWhere('full_name', 'like', '%' . $request->input('commercial_name') . '%');
            });
        }

        if ($request->filled('make')) {
            $germanDismantlers->where('make', 'like', '%' . $request->input('make') . '%');
        }

        $germanDismantlers = $germanDismantlers->paginate(150)->withQueryString();
        $request->flash();

        $uniquePlaintext = $ditoNumber->germanDismantlers()->select('manufacturer_plaintext')->distinct()->pluck('manufacturer_plaintext');
        $uniqueMake = $ditoNumber->germanDismantlers()->select('make')->distinct()->pluck('make');
        $uniqueCommercialNames = $ditoNumber->germanDismantlers()->select('commercial_name')->distinct()->pluck('commercial_name');

        return view('admin.dito-numbers.show',
            compact(
                'ditoNumber',
                'germanDismantlers',
                'relatedDismantlers',
                'plaintexts',
                'commercialNames',
                'uniqueMaxNet',
                'uniquePlaintext',
                'uniqueMake',
                'uniqueCommercialNames',
            )
        );
    }

    public function edit(DitoNumber $ditoNumber)
    {
        //
    }

    public function update(Request $request, DitoNumber $ditoNumber)
    {

        if ($request->filled('is_selection_completed')) {
            $ditoNumber->is_selection_completed = $request->input('is_selection_completed');
        }

        if ($request->filled('is_not_interesting')) {
            $ditoNumber->is_not_interesting = $request->input('is_not_interesting');
        }

        if ($ditoNumber->isDirty()) {
            $ditoNumber->save();
        }

        return redirect()->route('admin.dito-numbers.index');
    }

    public function destroy(DitoNumber $ditoNumber)
    {
        //
    }
}
