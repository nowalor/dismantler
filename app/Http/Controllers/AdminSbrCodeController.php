<?php

namespace App\Http\Controllers;

use App\Models\DitoNumber;
use App\Models\SbrCode;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSbrCodeController extends Controller
{
    public function index(Request $request) //: View
    {
        $sbrCodes = SbrCode::select(['id', 'sbr_code', 'name', ]);

        $totalSbrWithDito = SbrCode::whereHas('ditoNumbers')->count();
        $totalSbrWithoutDito = SbrCode::whereDoesntHave('ditoNumbers')->count();

        if($request->filled('search')) {
            $search = $request->get('search');

            $sbrCodes = $sbrCodes->where('name', 'LIKE', "%{$search}%");
        }

        if($request->filled('dito-connection')) {
            $ditoConnectionTypeFilter = $request->get('dito-connection');

            if($ditoConnectionTypeFilter === 'with') {
                $sbrCodes = $sbrCodes->whereHas('ditoNumbers');
            } else if($ditoConnectionTypeFilter === 'without') {
                $sbrCodes = $sbrCodes->whereDoesntHave('ditoNumbers');
            }
        }

        if($request->filled('car-parts')) {
            $carPartsFilter = $request->get('car-parts');

            if($carPartsFilter === 'with') {
                $sbrCodes = $sbrCodes->whereHas('carParts');
            } else if($carPartsFilter === 'without') {
                $sbrCodes = $sbrCodes->whereDoesntHave('carParts');
            }
        }

        $sbrCodes = $sbrCodes
            ->withCount('ditoNumbers')
            ->paginate(200);

        return view('admin.sbr-codes.index', compact(
            'sbrCodes',
            'totalSbrWithDito',
            'totalSbrWithoutDito')
        );
    }

    public function store(Request $request)
    {
        //
    }

    public function show(SbrCode $sbrCode)
    {
        $sbrCode->load('ditoNumbers');

        // Get all dito numbers except the ones connected to this sbr code
        $ditoNumbers = DitoNumber::whereDoesntHave('sbrCodes', function ($query) use ($sbrCode) {
            $query->where('sbr_code_id', $sbrCode->id);
        });

        $ditoNumbers = $ditoNumbers
            ->paginate(200);

        return view('admin.sbr-codes.show', compact('sbrCode', 'ditoNumbers'));
    }

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
