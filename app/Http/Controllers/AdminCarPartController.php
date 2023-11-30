<?php

namespace App\Http\Controllers;

use App\Models\CarPart;
use App\Models\CarPartType;
use App\Models\DismantleCompany;
use Illuminate\Http\Request;

class AdminCarPartController extends Controller
{

    public function index(Request $request)
    {
        $parts = CarPart::has('ditoNumber.germanDismantlers')
            ->whereNotNull('engine_type_id');

        if ($request->filled('part-type')) {

            $value = $request->input('part-type');

            $parts = $parts->whereHas('carPartType', function ($query) use ($value) {
                return $query->where('name', 'like', "%$value%");
            });
        }

        if($request->filled('dismantle-company')) {
            $value = $request->input('dismantle-company');

            $parts = $parts->whereHas('dismantleCompany', function ($query) use ($value) {
               return $query->where('name', 'like', "%$value%");
            });
        }

        $parts = $parts->with('carPartImages', function ($query) {
            $query->where('origin_url', 'like', '%part-image%');
        })->paginate(15);

        $partTypes = CarPartType::all();

        $dismantleCompanies = DismantleCompany::all();

        return view('admin.car-parts.index', compact('parts', 'partTypes', 'dismantleCompanies'));
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

    public function show(CarPart $carPart)
    {
        $carPart->load(
            'carPartImages',
            'carPartType',
            'ditoNumber.germanDismantlers.engineTypes',
            'ditoNumber.germanDismantlers.ditoNumbers',
            'dismantleCompany',
        );

        /* $totalKba= $carPart->ditoNumber->germanDismantlers->count();
        $totalEngineTypeConnected = $carPart->ditoNumber->germanDismantlers->engineTypes->count(); */


        return view('admin.car-parts.show', compact('carPart'));
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
