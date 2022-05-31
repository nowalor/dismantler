<?php

namespace App\Http\Controllers;

use App\Models\DitoNumber;
use Illuminate\Http\Request;

class AdminDitoNumbersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\DitoNumber  $ditoNumber
     * @return \Illuminate\Http\Response
     */
    public function show(DitoNumber $ditoNumber)
    {
        return view('admin.dito-numbers.show', compact('ditoNumber'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DitoNumber  $ditoNumber
     * @return \Illuminate\Http\Response
     */
    public function edit(DitoNumber $ditoNumber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DitoNumber  $ditoNumber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DitoNumber $ditoNumber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DitoNumber  $ditoNumber
     * @return \Illuminate\Http\Response
     */
    public function destroy(DitoNumber $ditoNumber)
    {
        //
    }
}
