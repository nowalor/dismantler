<?php

namespace App\Http\Controllers;

use App\Models\DitoNumber;
use App\Models\GermanDismantler;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

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
    public function show(DitoNumber $ditoNumber, Request $request)
    {
        $germanDismantlers;
        $search = $request->input('search');

        if($search) {
            $germanDismantlers = GermanDismantler::where('manufacturer_plaintext', 'like', '%' . $search . '%')->paginate(100);

        } else {
            $germanDismantlers = GermanDismantler::paginate(100);
        }

        $relatedDismantlers = $ditoNumber->germanDismantlers;

        return view('admin.dito-numbers.show', compact('ditoNumber', 'germanDismantlers', 'relatedDismantlers'));
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

    public function search(Request $request)
    {
        $search = $request->input('search');


    }
}
