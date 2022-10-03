<?php

namespace App\Http\Controllers;

use App\Models\CarPart;
use App\Models\CarPartType;
use App\Models\DismantleCompany;
use App\Models\GermanDismantler;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CarPartController extends Controller
{
    public function index(Request $request)
    {
        $parts = CarPart::all();

        if($request->filled('hsn') && $request->filled('tsn')) {
            $kba = GermanDismantler::where('hsn', $request->input('hsn'))
                 ->where('tsn', $request->input('tsn'))
                 ->first();

            $engineTypeNames = $kba->engineTypes->pluck('name');

            $parts = CarPart::whereIn('engine_code', $engineTypeNames)
                ->with('carPartImages',
                    fn($query) => $query->where('origin_url', 'like', '%part-image%')
                );

            $namesFromDitoNumbers = [];
            foreach($kba->ditoNumbers as $ditoNumber) {
                /* $date = date_parse($ditoNumber->production_date);
                $month = $date['month'];
                $day = $date['day'];
                $monthWithZero = $month < 10 ? "0$month" : $month;
                $dayWithZero = $day < 10 ? "0$day" : $day;

                $dateStr = "$monthWithZero-$dayWithZero"; */
                $name = "$ditoNumber->producer $ditoNumber->brand";

                array_push($namesFromDitoNumbers, $name);


            }

            $parts->where( function($query) use($namesFromDitoNumbers) {
                foreach($namesFromDitoNumbers as $name) {
                    $query->orWhere('name', 'like', "%$name%");
                }
            });
        }

        if($request->filled('advanced_search')) {
            $search = $request->input('advanced_search');

            $parts = $parts->where('engine_code', 'like', "%$search%");

            // Need to check against all relevant fields in the database..
            if($request->input('search_by') === 'everything') {

            }
        }

        $parts = $parts->paginate(15);

        $partTypes = CarPartType::all();

        $dismantleCompanies = DismantleCompany::all();

        return view('car-parts.index', compact('parts', 'partTypes', 'dismantleCompanies', 'kba'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarPart  $carPart
     * @return \Illuminate\Http\Response
     */
    public function show(CarPart $carPart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CarPart  $carPart
     * @return \Illuminate\Http\Response
     */
    public function edit(CarPart $carPart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarPart  $carPart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarPart $carPart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarPart  $carPart
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarPart $carPart)
    {
        //
    }
}
