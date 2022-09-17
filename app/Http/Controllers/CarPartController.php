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

        $parts = CarPart::where('car_part_type_id', 3574)
            ->with('carPartImages', fn($query) => $query->where('origin_url', 'like', '%part-image%'))
            ->paginate(15);

        if($request->has('hsn') && $request->has('tsn')) {
            $kba = GermanDismantler::where('hsn', $request->input('hsn'))
                 ->where('tsn', $request->input('tsn'))
                 ->first();

            return $kba;

            $string = $kba->ditoNumbers[0]['producer'] . ' ' . $kba->ditoNumbers[0]['brand'];


            $parts = CarPart::where('name', 'like', "%$string%")->get();

            return $parts;

             return $kba->ditoNumbers;
        }

        $partTypes = CarPartType::all();

        $dismantleCompanies = DismantleCompany::all();

        return view('car-parts.index', compact('parts', 'partTypes', 'dismantleCompanies'));
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
