<?php

namespace App\Http\Controllers;

use App\Models\DitoNumber;
use App\Models\SbrCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AdminDitoNumberSbrCodeController extends Controller
{
    public function index(DitoNumber $ditoNumber, Request $request): View
    {
        $ditoNumber->load('sbrCodes');

        $query = SbrCode::where(function ($query) use ($ditoNumber) {
            $query->where('name', 'LIKE', "%$ditoNumber->producer%");
            $query->orWhere('name', 'LIKE', "%$ditoNumber->brand%");
        })->whereDoesntHave('ditoNumbers', function ($query) use ($ditoNumber) {
            $query->where('id', $ditoNumber->id);
        });

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', "%{$request->get('search')}%");
        }

        $sbrCodes = $query->paginate(150);


        return view('admin.dito-numbers.sbr-codes.index', compact('ditoNumber', 'sbrCodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }


    public function store(DitoNumber $ditoNumber, Request $request)
    {
        if (!$request->filled('sbr_code_checkboxes')) {
            return redirect()->back()->with('error', 'No SBR Codes selected.');
        }

        $ditoNumber->sbrCodes()->syncWithoutDetaching($request->get('sbr_code_checkboxes'));

        return redirect()->back()->with('success', 'SBR Codes added.');
    }

    /**
     * Display the specified resource.
     *
     * @param DitoNumber $ditoNumber
     * @return Response
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
     * @param DitoNumber $ditoNumber
     * @return Response
     */
    public function edit(DitoNumber $ditoNumber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param DitoNumber $ditoNumber
     * @return Response
     */
    public function update(Request $request, DitoNumber $ditoNumber)
    {
        //
    }


    public function destroy(
        DitoNumber $ditoNumber,
        SbrCode    $sbrCode,
    ): RedirectResponse
    {
        $ditoNumber->sbrCodes()->detach($sbrCode);

        return redirect()->back()->with('success', 'SBR Code removed.');
    }
}
