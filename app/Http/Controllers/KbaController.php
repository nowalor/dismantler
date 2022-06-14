<?php

namespace App\Http\Controllers;

use App\Models\GermanDismantler;
use App\Models\EngineType;
use App\Models\CommercialName;
use App\Models\ManufacturerText;
use Illuminate\Http\Request;
use App\Models\EngineTypeGermanDismantler;
use Illuminate\Support\Carbon;

class KbaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $germanDismantlers = GermanDismantler::query();

        $plaintexts = ManufacturerText::all();
        $commercialNames = CommercialName::all();

        if($request->filled('plaintext')) {

           $germanDismantlers->where('manufacturer_plaintext', 'like', '%' . $request->input('plaintext') . '%');
        }

       if($request->filled('commercial_name')) {
           $germanDismantlers->where('commercial_name', 'like', '%' . $request->input('commercial_name') . '%');
       }

       if($request->filled('make')) {
           $germanDismantlers->where('make', 'like', '%'  . $request->input('make') . '%');
       }

        if($request->filled('date_from')) {
           $fromDate = Carbon::parse($request->input('date_from'));
           $germanDismantlers
               ->where('date_of_allotment', '>=', $fromDate);

       }

       if($request->filled('date_to')) {
           $toDate = Carbon::parse($request->input('date_to'));
           $germanDismantlers
               ->where('date_of_allotment', '<=', $toDate);
      }

      if($request->filled('sort_by')) {
            $germanDismantlers->orderBy($request->input('sort_by'));
        }

      $germanDismantlers = $germanDismantlers->paginate(250);

      return view('admin.kba.index', compact('germanDismantlers', 'plaintexts', 'commercialNames'));
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

    public function storeConnectionToEngineType(GermanDismantler $kba, Request $request)
    {
        EngineTypeGermanDismantler::create([
            'engine_type_id' => $request->input('engine-type-id'),
            'german_dismantler_id' => $kba->id,
        ]);

        return redirect()->back()->with('connection-saved', 'Connection saved successfully');
    }

    public function deleteConnectionToEngineType(GermanDismantler $kba, Request $request)
    {
        EngineTypeGermanDismantler::where([
            ['engine_type_id', $request->input('engine_type_id')],
            ['german_dismantler_id', $kba->id],
        ])->delete();

        return redirect()->back()->with('connection-deleted', 'Connection deleted');
    }


    public function show(GermanDismantler $kba, Request $request)
    {
        $engineTypes = EngineType::whereDoesntHave(
            'germanDismantlers',
            fn($query) => $query->where('id', $kba->id)
            );

        $relatedEngineTypes = $kba->engineTypes;

        if($request->filled('search')) {
            $engineTypes = EngineType::where('name', 'like', '%' . $request->input('search') . '%')->get();
        } else {
            $engineTypes = $engineTypes->get();
        }

        return view('admin.kba.show', compact('kba', 'engineTypes', 'relatedEngineTypes'));
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
