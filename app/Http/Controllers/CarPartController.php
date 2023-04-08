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
    public function index(Request $request)// : View | RedirectResponse
    {
        $parts = CarPart::select(['id', 'name', 'oem_number', 'price3', 'engine_type', 'car_part_type_id'])->
        with('ditoNumber', 'carPartType');
        $kba = null;

        $brands = CarBrand::all();

        $ditoNumber = null;

        $partsDifferentCarSameEngineType = null;

        if (
            ($request->filled('hsn') && !$request->filled('tsn')) ||
            ($request->filled('tsn') && !$request->filled('hsn'))
        ) {
            $errors = ['hsn' => 'Please fill in both HSN and TSN'];

            return $this->redirectBack($errors);
        }

        if ($request->filled('hsn') && $request->filled('tsn')) {
            $kba = GermanDismantler::where('hsn', $request->input('hsn'))
                ->where('tsn', $request->input('tsn'))
                ->with('engineTypes')
                ->with('ditoNumbers')
                ->first();

            $engineTypeNames = $kba->engineTypes->pluck('name');



            $ditoNumber = $kba->ditoNumbers->first();

            if (is_null($ditoNumber)) {
                $errors = [
                    'error' => 'We could not find information on your car based on the HSN + TSN',
                    'error3' => '!',
                ];

                return $this->redirectBack($errors);
            }

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
            $parts = $parts->whereIn('id', $carPartIds)
                 ->whereIn('engine_code', $engineTypeNames)
                ->with('carPartImages');


            $partsDifferentCarSameEngineType = CarPart::whereNot('dito_number_id', $ditoNumber->id)
                ->whereIn('engine_code', $engineTypeNames)
                ->paginate(8, pageName: 'parts_from_different_cars');
        }

        if (
            $request->filled('brand')
        ) {
            $brand = $request->input('brand');

            if (!is_null($ditoNumber) && $ditoNumber->producer !== $brand) {
                $errors = [
                    'error' => "Car model does not match the brand of the HSN + TSN. We detected that the model of the car matching the HSN + TSN is $ditoNumber->producer while you selected $brand",
                    'error2' => '!',
                ];

                return $this->redirectBack($errors);
            }

            $parts = $parts->where('name', 'like', "%$brand%");
        }

        if ($request->filled('advanced_search')) {
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

        $parts = $parts
            ->with('carPartImages')
            ->paginate(9, pageName: 'parts');

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
            'ditoNumber'
        ));
    }

    public function show(CarPart $carPart)
    {

        return view('car-parts.show', compact(
            'carPart'
        ));
    }

    public function update(Request $request, CarPart $carPart)
    {
        //
    }


    // Non-Resourceful Methods
    public function searchByCode(): mixed
    {

    }

    public function searchByModel(): mixed
    {

    }

    // Private methods for modularizing this controller
    private function redirectBack(array $errors): RedirectResponse
    {
        request()?->flash();

        return redirect()->back()->withErrors($errors);
    }

}
