<?php

namespace App\Http\Controllers;

use App\Models\SbrCode;
use Illuminate\Http\Request;

class AdminSbrCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sbrCodes = SbrCode::paginate(200);

        return view('admin.sbr-codes.index', compact('sbrCodes'));
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
     * @param  \App\Models\SbrCode  $sbrCode
     * @return \Illuminate\Http\Response
     */
    public function show(SbrCode $sbrCode)
    {
        return 'show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SbrCode  $sbrCode
     * @return \Illuminate\Http\Response
     */
    public function edit(SbrCode $sbrCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SbrCode  $sbrCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SbrCode $sbrCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SbrCode  $sbrCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(SbrCode $sbrCode)
    {
        //
    }
}
