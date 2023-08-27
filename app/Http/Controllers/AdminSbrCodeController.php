<?php

namespace App\Http\Controllers;

use App\Models\DitoNumber;
use App\Models\SbrCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSbrCodeController extends Controller
{
    public function index(Request $request) //: View
    {
        $sbrCodes = SbrCode::select(['id', 'sbr_code', 'name',])
            ->withCount('ditoNumbers')
            ->withCount('carParts');

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

        if($request->filled('sort')) {
            $sortBy = $request->get('sort');

            if($sortBy === 'car-parts') {
                $sbrCodes = $sbrCodes->orderBy('car_parts_count', 'desc');
            }
        }

        $sbrCodes = $sbrCodes->paginate(200);

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

    public function show(SbrCode $sbrCode, Request $request)
    {
        $sbrCode->load('ditoNumbers')->loadCount('carParts');

        // Get all dito numbers except the ones connected to this sbr code
        $ditoNumbers = DitoNumber::query();

        if($request->filled('search')) {
            $search = $request->get('search');

            $ditoNumbers = $ditoNumbers->where(function ($query) use ($search) {
                $query->where('dito_number', 'LIKE', "%{$search}%")
                    ->orWhere('brand', 'LIKE', "%{$search}%")
                    ->orWhere('producer', 'LIKE', "%{$search}%")
                    ->orWhere('production_date', 'LIKE', "%{$search}%");
            });
        }

        $ditoNumbers = $ditoNumbers
            ->whereNotIn('id', $sbrCode->ditoNumbers->pluck('id')->toArray())
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


    public function destroy(SbrCode $sbrCode, Request $request) : RedirectResponse
    {
        if(!$request->filled('dito_number')) {
            return redirect()->back();
        }

        $sbrCode->ditoNumbers()->detach($request->get('dito_number'));

        return redirect()->back();
    }
}
