<?php

namespace App\Http\Controllers;

use App\Models\DitoNumber;
use App\Models\GermanDismantler;
use App\Models\ManufacturerText;
use App\Models\CommercialName;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class AdminDitoNumbersController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(DitoNumber $ditoNumber, Request $request)
    {
        $plaintexts = ManufacturerText::all();
        $commercialNames = CommercialName::all();

        $germanDismantlers = GermanDismantler::whereDoesntHave(
              'ditoNumbers',
              fn($query) => $query->where('id', $ditoNumber->id)
         );

        $relatedDismantlers = $ditoNumber->germanDismantlers;

        $germanDismantlers = $germanDismantlers->paginate(100)->withQueryString();

        return view('admin.dito-numbers.show', compact('ditoNumber', 'germanDismantlers', 'relatedDismantlers', 'plaintexts', 'commercialNames'));
    }

    public function filter(DitoNumber $ditoNumber, Request $request)
    {
        $germanDismantlers = GermanDismantler::whereDoesntHave(
            'ditoNumbers',
            fn($query) => $query->where('id', $ditoNumber->id)
        );

        $plaintexts = ManufacturerText::all();
        $commercialNames = CommercialName::all();

        $relatedDismantlers = $ditoNumber->germanDismantlers;

        if($request->input('plaintext')) {
            $germanDismantlers->where('manufacturer_plaintext', $request->input('plaintext'));
        }

        if($request->input('commercial_name')) {
            $germanDismantlers->where('commercial_name', $request->input('commercial_name'));
        }

        if($request->input('search')) {
            $germanDismantlers = $germanDismantlers
                ->where(function($innerQuery) use($request) {
                     $innerQuery->where('manufacturer_plaintext', 'like', '%' . $request->input('search') . '%');
                     $innerQuery->orWhere('commercial_name', 'like', '%' . $request->input('search') . '%');
                     $innerQuery->orWhere('make', 'like', '%' . $request->input('search') . '%');
                     $innerQuery->orWhere('date_of_allotment_of_type_code_number', 'like', '%' . $request->input('search'). '%');
                });
        }

        $germanDismantlers = $germanDismantlers->paginate(100)->withQueryString();

        return  view('admin.dito-numbers.show',
            compact('ditoNumber', 'germanDismantlers', 'relatedDismantlers', 'plaintexts', 'commercialNames')
        );
    }

    public function edit(DitoNumber $ditoNumber)
    {
        //
    }

    public function update(Request $request, DitoNumber $ditoNumber)
    {
        //
    }

    public function destroy(DitoNumber $ditoNumber)
    {
        //
    }
}
