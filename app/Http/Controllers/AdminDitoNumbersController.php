<?php

namespace App\Http\Controllers;

use App\Models\DitoNumber;
use App\Models\GermanDismantler;
use App\Models\ManufacturerText;
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

    public function show(DitoNumber $ditoNumber, Request $request)
    {
        $search = $request->input('search');

        $plaintexts = ManufacturerText::all();

      $germanDismantlers = GermanDismantler::whereDoesntHave(
                  'ditoNumbers',
                  fn($query) => $query->where('id', $ditoNumber->id)
             );

        if($search) {
            $germanDismantlers = $germanDismantlers
                ->where(function($innerQuery) use($search) {
                     $innerQuery->where('manufacturer_plaintext', 'like', '%' . $search . '%');
                     $innerQuery->orWhere('commercial_name', 'like', '%' . $search . '%');
                     $innerQuery->orWhere('make', 'like', '%' . $search . '%');
                     $innerQuery->orWhere('date_of_allotment_of_type_code_number', 'like', '%' . $search . '%');
                });
        }

        $relatedDismantlers = $ditoNumber->germanDismantlers;

        $germanDismantlers = $germanDismantlers->paginate(100)->withQueryString();

        return view('admin.dito-numbers.show', compact('ditoNumber', 'germanDismantlers', 'relatedDismantlers', 'plaintexts'));
    }

    public function filter(DitoNumber $ditoNumber, Request $request)
    {
        $germanDismantlers = GermanDismantler::whereDoesntHave(
            'ditoNumbers',
            fn($query) => $query->where('id', $ditoNumber->id)
        );

        $plaintexts = ManufacturerText::all();

        $relatedDismantlers = $ditoNumber->germanDismantlers;

        if($request->input('plaintext')) {
            $germanDismantlers->where('manufacturer_plaintext', $request->input('plaintext'));
        }

        $germanDismantlers = $germanDismantlers->paginate(100)->withQueryString();

        return view('admin.dito-numbers.show', compact('ditoNumber', 'germanDismantlers', 'relatedDismantlers', 'plaintexts'));
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
