<?php

namespace App\Http\Controllers;

use App\Models\GermanDismantler;
use Illuminate\Http\Request;

class KbaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dismantlers = GermanDismantler::paginate(250);

        return view('admin.kba.index', compact('dismantlers'));
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
     * @param  \App\Models\GermanDismantler  $germanDismantler
     * @return \Illuminate\Http\Response
     */
    public function show(GermanDismantler $kba)
    {
        return view('admin.kba.show', compact('kba'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GermanDismantler  $germanDismantler
     * @return \Illuminate\Http\Response
     */
    public function edit(GermanDismantler $germanDismantler)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GermanDismantler  $germanDismantler
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GermanDismantler $germanDismantler)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GermanDismantler  $germanDismantler
     * @return \Illuminate\Http\Response
     */
    public function destroy(GermanDismantler $germanDismantler)
    {
        //
    }
}
