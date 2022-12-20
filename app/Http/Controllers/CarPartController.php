<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use App\Models\CarPart;
use App\Models\CarPartType;
use App\Models\DismantleCompany;
use App\Models\GermanDismantler;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CarPartController extends Controller
{
    public function index(Request $request) // : View | RedirectResponse
    {
        $parts = CarPart::query();
        $kba = null;

        $brands = CarBrand::all();

        $partsDifferentCarSameEngineType = null;

        if (
            ($request->filled('hsn') && !$request->filled('tsn')) ||
            ($request->filled('tsn') && !$request->filled('hsn'))
        ) {
            return redirect()->back()->withErrors([
                'hsn_or_tsn_missing' => 'Both HSN and TSN must be included if you want to search with them',
            ]);
        }

        // Only need to filter by brand
        // If HSN and TSN not filled
        // Because otherwise we filter by car name anyway
        // Which includes the brand
        if (
            $request->filled('brand') &&
            !$request->filled('hsn') &&
            !$request->filled('tsn')
        ) {
            $brand = $request->input('brand');

            $parts = $parts->where('name', 'like', "%$brand%")
                ->with('carPartImages',)
                ->paginate(10, pageName: 'parts');
        }

        if (
            $request->filled('advanced_search') &&
            !$request->filled('hsn') &&
            !$request->filled('tsn')
        ) {
            $search = $request->input('advanced_search');

            $parts = $parts
                ->where('engine_code', 'like', "%$search%")
                ->orWhere('engine_type', 'like', "%$search%");

            // Need to check against all relevant fields in the database
            if ($request->input('search_by') === 'everything') {
                $parts->orWhere('item_code', 'like', "%$search%")
                    ->orWhere('oem_number', 'like', "%$search%")
                    ->orWhere('comments', 'like', "%$search%")
                    ->orWhere('transmission_type', 'like', "%$search%")
                    ->orWhere('alternative_numbers', 'like', "%$search%")
                    ->orWhere('kilo_watt', 'like', "%$search%");
            }
        }

        if ($request->filled('hsn') && $request->filled('tsn')) {
            $kba = GermanDismantler::where('hsn', $request->input('hsn'))
                ->where('tsn', $request->input('tsn'))
                ->with('engineTypes')
                ->with('ditoNumbers')
                ->first();

            $engineTypeNames = $kba->engineTypes->pluck('name');

            $ditoNumber = $kba->ditoNumbers->first();

            $carPartIds = GermanDismantler::with('ditoNumbers.carParts')
                ->where('hsn', $request->input('hsn'))
                ->where('tsn', $request->input('tsn'))
                ->get()
                ->pluck('ditoNumbers')
                ->collapse()
                ->pluck('carParts')
                ->collapse()
                ->unique('id')
                ->pluck('id')
                ->values();


            $parts = CarPart::whereIn('id', $carPartIds)
                ->whereIn('engine_type', $engineTypeNames)
                ->with('carPartImages',
                    fn($query) => $query->where('origin_url', 'like', '%part-image%')
                )
                ->paginate(8, pageName: 'parts');

            $partsDifferentCarSameEngineType = CarPart::whereNot('dito_number_id', optional($ditoNumber)->id)
                ->whereNotIn('engine_type', $engineTypeNames)
                ->with('carPartImages',
                    fn($query) => $query->where('origin_url', 'like', '%part-image%')
                )
                ->paginate(8, pageName: 'parts_from_different_cars');


        }

        $partTypes = CarPartType::all();
        $dismantleCompanies = DismantleCompany::all();


        return view('car-parts.index', compact
        (
            'parts',
            'partTypes',
            'dismantleCompanies',
            'kba',
            'partsDifferentCarSameEngineType',
            'brands',
        ));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    public function show(CarPart $carPart)
    {
        $carPart->load(['carPartImages' =>
                fn($query) => $query->where('origin_url', 'like', '%part-image%')]
        );

        return view('car-parts.show', compact(
            'carPart'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CarPart $carPart
     * @return Response
     */
    public function edit(CarPart $carPart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param CarPart $carPart
     * @return Response
     */
    public function update(Request $request, CarPart $carPart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CarPart $carPart
     * @return Response
     */
    public function destroy(CarPart $carPart)
    {
        //
    }
}
