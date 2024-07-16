<?php

namespace App\Http\Controllers;

use App\Actions\Parts\SearchByKbaAction;
use App\Actions\Parts\SearchByModelAction;
use App\Actions\Parts\SearchByOeAction;
use App\Models\CarBrand;
use App\Models\CarPart;
use App\Models\CarPartType;
use App\Models\DismantleCompany;
use App\Models\DitoNumber;
use App\Models\GermanDismantler;
use App\Models\NewCarPart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CarPartController extends Controller
{
    public function index(Request $request)// : View | RedirectResponse
    {
        $parts = NewCarPart::select([
            'id',
            'name',
            'oem_number',
            'price3',
            'engine_type',
            'car_part_type_id'
        ])->with('ditoNumber', 'carPartType');

        $kba = null;

        $brands = CarBrand::all();

        $ditoNumber = null;

        $partsDifferentCarSameEngineType = null;

        if (
            $request->filled('brand')
        ) {
            $brand = $request->input('brand');

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
    public function searchByCode(Request $request): mixed
    {
        if (
            ($request->filled('hsn') && !$request->filled('tsn')) ||
            ($request->filled('tsn') && !$request->filled('hsn'))
        ) {
            $errors = ['hsn' => 'Please fill in both HSN and TSN'];

            return $this->redirectBack($errors);
        }

        $type = null;

        if ($request->filled('part-type')) {
            $type = CarPartType::find($request->get('part-type'));
        }


        $response = (new SearchByKbaAction())->execute(
            hsn: $request->get('hsn'),
            tsn: $request->get('tsn'),
            type: $type,
            paginate: 2,
        );

        if (!$response['success']) {
            dd('Unhandeled error, let nikulas know');
        }

        $parts = $response['data']['parts'];
        $kba = $response['data']['kba'];

        $search = [
            'tsn' => $request->get('tsn'),
            'hsn' => $request->get('hsn'),
            'part-type' => $request->get('part-type'),
        ];

        $partTypes = CarPartType::all();

        return view('parts-kba', compact('parts', 'search', 'partTypes', 'kba'));
    }

    private function redirectBack(array $errors): RedirectResponse
    {
        request()?->flash();

        return redirect()->back()->withErrors($errors);
    }

    public function searchByModel(Request $request): mixed
{
    $dito = DitoNumber::find($request->get('dito_number_id'));

    if(!$dito) {
        abort('fail');
    }

    $type = null;

    if($request->filled('type_id')) {
        $type = CarPartType::find($request->get('type_id'));
    }

    $sort = $request->query('sort'); // Get the sort parameter from the request

    $filters = [];
    foreach ($request->input('filter', []) as $key => $value) {
        if (!empty($value)) {
            $filters[$key] = $value;
        }
    }

    $results = (new SearchByModelAction())->execute(
        model: $dito,
        type: $type,
        sort: $sort, // Pass the sort parameter to the action
        filters: $filters, 
        paginate: 10,
    );

    $parts = $results['data']['parts'];

    $types = CarPartType::all();

    return view('parts-model', compact(
        'parts',
        'dito',
        'type', // Prev selected type, used to autofill search
        'types'
    ));
}


public function searchByOEM(Request $request)
{
    $oem = $request->get('oem');
    $engine_code = $request->get('engine_code');
    $gearbox = $request->get('gearbox');

    $results = (new SearchByOeAction())->execute(
        oem: $oem,
        engine_code: $engine_code,
        gearbox: $gearbox,
        paginate: 10,
    );

    $parts = $results['data']['parts'];

    return view('parts-oem', compact('parts', 'oem', 'engine_code', 'gearbox'));
}


}
