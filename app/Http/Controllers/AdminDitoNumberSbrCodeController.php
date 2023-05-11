<?php

namespace App\Http\Controllers;

use App\Models\DitoNumber;
use App\Models\SbrCode;
use Illuminate\Http\Request;

class AdminDitoNumberSbrCodeController extends Controller
{
    public function index(DitoNumber $ditoNumber)
    {
        $ditoNumber->load('sbrCodes');

        $sbrCodes = SbrCode::where('name', 'LIKE', "%$ditoNumber->producer%")
            ->orWhere('name', 'LIKE', "%$ditoNumber->brand%")
            ->paginate(150);

        $ditoNumber->sbrCodes;

        return view('admin.dito-numbers.sbr-codes.index', compact('ditoNumber', 'sbrCodes'));
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


    public function store(DitoNumber $ditoNumber, Request $request)
    {
        if(!$request->filled('sbr_code_checkboxes')) {
            return redirect()->back()->with('error', 'No SBR Codes selected.');
        }

        $ditoNumber->sbrCodes()->syncWithoutDetaching($request->get('sbr_code_checkboxes'));

        return redirect()->back()->with('success', 'SBR Codes added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DitoNumber  $ditoNumber
     * @return \Illuminate\Http\Response
     */
    public function show(DitoNumber $ditoNumber)
    {
        return $ditoNumber;
        $sbrCodes = SbrCode::where('name', 'LIKE', "%{$ditoNumber->brand}%")
           // ->orWhere('name', 'LIKE', "%{$ditoNumber->brand}%")
            ->count();

        return "count: $sbrCodes";
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
