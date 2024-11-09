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
use App\Actions\Parts\SortPartsAction;
use Illuminate\Support\Facades\Cache;


class CarPartController extends Controller
{

    private const SEARCHABLE_COLUMNS = [
        'id',
        'new_name',
        'quality',
        'original_number',
        'article_nr',
        'mileage_km',
        'model_year',
        'engine_type',
        'fuel',
        'price_sek',
        'sbr_car_name',
        'gearbox_nr',
        'vin'
    ];

    // : View | RedirectResponse
    public function index(Request $request)
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

        return view('car-parts.index', compact(
            'parts',
            'partTypes',
            'dismantleCompanies',
            'kba',
            'partsDifferentCarSameEngineType',
            'brands',
            'ditoNumber'
        ));
    }

    public function searchParts(Request $request)
    {
        // Retrieve the search query, part type, sorting, and filters
        $search = $request->input('search');
        $sort = $request->query('sort');
        $filters = $request->input('filter', []);
        $partType = $request->query('type_id'); // Retrieve the part type filter

        // Reset to the first page if filters are applied
        if (!empty($filters) || $partType) {
            $request->merge(['parts' => 1]);
        }

        $type = null;

        if ($request->filled('type_id')) {
            $type = CarPartType::find($request->get('type_id'));
        }

        // Begin building the query
        $parts = NewCarPart::with([
            'carPartType',
            'dismantleCompany',
            'sbrCode',
        ]);


        if (!empty($search)) {
            $parts->where(function ($query) use ($search) {
                foreach (self::SEARCHABLE_COLUMNS as $column) {
                    $query->orWhere($column, 'like', "%$search%");
                }
            });
        }

        // Apply part type filter if provided
        if (!empty($partType)) {
            $parts->where('car_part_type_id', $partType);
        }

        // Apply additional filters dynamically
        foreach ($filters as $key => $value) {
            $parts->when(!empty($value), function ($query) use ($key, $value) {
                return $query->where($key, $value);
            });
        }

        // Apply sorting if available
        $parts = (new SortPartsAction())->execute($parts, $sort);

        // Paginate the results
        $parts = $parts->paginate(9, ['*'], 'parts')->appends($request->query());

        // Fetch related data for dropdowns or filters, with caching
        $brands = Cache::remember('car_brands', 60, function () {
            return CarBrand::all();
        });

        $partTypes = Cache::remember('car_part_types', 60, function () {
            return CarPartType::all();
        });

        $dismantleCompanies = Cache::remember('dismantle_companies', 60, function () {
            return DismantleCompany::all();
        });

        // Return the view with the filtered data
        return view('browse-car-parts', compact(
            'parts',
            'partTypes',
            'type',
            'dismantleCompanies',
            'brands'
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
        // Capture HSN, TSN, and Part Type from the request
        $hsn = $request->get('hsn');
        $tsn = $request->get('tsn');
        $type = $request->filled('type_id') ? CarPartType::find($request->get('type_id')) : null;

        // Validate presence of HSN and TSN
        if (!$hsn || !$tsn) {
            return redirect()->back()->with('error', 'HSN and TSN are required for the search.');
        }

        // Perform the initial KBA search
        $response = (new SearchByKbaAction())->execute(
            hsn: $hsn,
            tsn: $tsn,
            type: $type,
            sort: $request->query('sort'),
            paginate: 10 // Ensure we paginate results here
        );

        if (!$response['success']) {
            return response()->json(['message' => 'KBA not found or parts are unavailable']);
        }

        // Extract parts and other data from the response
        $parts = $response['data']['parts'];
        $kba = $response['data']['kba'];
        $partCount = count($parts);

        // Check if there is an additional search term provided
        if ($request->filled('search')) {
            $search = $request->get('search');


            $parts = $parts->filter(function ($part) use ($search) {
                foreach (self::SEARCHABLE_COLUMNS as $column) {
                    if (stripos($part->$column, $search) !== false) {
                        return true;
                    }
                }
                return false;
            });
            $partCount = count($parts);
        }

        // Prepare the search parameters for display and further actions
        $search = [
            'hsn' => $hsn,
            'tsn' => $tsn,
            'type_id' => $request->get('type_id'),
            'search' => $request->get('search'), // Include the new search term
        ];

        $partTypes = CarPartType::all();

        // Return the view with the updated parts and search parameters
        return view('parts-kba', compact(
            'parts',
            'search',
            'partTypes',
            'type',
            'kba',
            'partCount'
        ));
    }


    private function redirectBack(array $errors): RedirectResponse
    {

        request()?->flash();

        return redirect()->back()->withErrors($errors);
    }


    public function searchByModel(Request $request): mixed
    {
        // Find the Dito number
        $dito = DitoNumber::find($request->get('dito_number_id'));

        if (!$dito) {
            abort(404, 'Dito number not found.');
        }

        // Find the Car Part Type if specified
        $type = null;
        if ($request->filled('type_id') && $request->get('type_id') !== 'all') {
            $type = CarPartType::find($request->get('type_id'));
        }

        // Sorting and filtering logic
        $sort = $request->query('sort');
        $filters = [];
        foreach ($request->input('filter', []) as $key => $value) {
            if (!empty($value)) {
                $filters[$key] = $value;
            }
        }

        // Execute the search
        $results = (new SearchByModelAction())->execute(
            model: $dito,
            type: $type,
            sort: $sort,
            filters: $filters,
            paginate: 10
        );

        $parts = $results['data']['parts'];
        $partCount = $parts->total(); // Get the total count from the paginator

        // If there's a secondary search term, apply it
        if ($request->filled('search')) {
            $search = $request->get('search');


            $parts = $parts->filter(function ($part) use ($search) {
                foreach (self::SEARCHABLE_COLUMNS as $column) {
                    if (stripos($part->$column, $search) !== false) {
                        return true;
                    }
                }
                return false;
            });

            $partCount = $parts->count();
        }

        // Prepare the search parameters for display and further actions
        $search = [
            'dito_number_id' => $request->get('dito_number_id'),
            'brand' => $request->get('brand'),
            'type_id' => $request->get('type_id'),
            'search' => $request->get('search'), // Secondary search term
        ];

        // Get all car part types
        $partTypes = CarPartType::all();

        return view('parts-model', compact(
            'parts',
            'search',
            'dito',
            'type',
            'partTypes',
            'partCount'
        ));
    }


    public function searchByOEM(Request $request)
    {
        $oem = $request->get('oem');
        $engine_code = $request->get('engine_code');
        $gearbox = $request->get('gearbox');
        $search = $request->query('search'); // Capture the search term
        $sort = $request->query('sort');
        $type_id = $request->query('type_id'); // Capture the type_id from the request

        // Prepare the query based on filters and the search term
        $results = (new SearchByOeAction())->execute(
            oem: $oem,
            engine_code: $engine_code,
            gearbox: $gearbox,
            search: $search, // Pass the search term
            sort: $sort, // Pass the sort parameter
            type_id: $type_id, // Pass the type_id
            paginate: 10,
        );

        $type = null;

        if ($request->filled('type_id')) {
            $type = CarPartType::find($request->get('type_id'));
        }

        $parts = $results['data']['parts'];
        $partTypes = CarPartType::all();

        return view('parts-oem', compact(
            'parts',
            'type',
            'oem',
            'engine_code',
            'gearbox',
            'partTypes'
        ));
    }

    public function searchByNumberPlate()
    {

    }
}
