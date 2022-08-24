<?php

namespace App\Http\Controllers;

use App\Models\CarPart;
use Illuminate\Http\Request;

class AdminCarPartController extends Controller
{

    public function index()
    {
        $parts = CarPart::with('carPartImages')->paginate(15);

        return view('admin.car-parts.index', compact('parts'));
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
