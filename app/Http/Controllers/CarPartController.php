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
use App\Models\MainCategory;


class CarPartController extends BaseController
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
            'original_number',
            'engine_type',
            'car_part_type_id'
        ])->with('ditoNumber', 'carPartType')->whereNull('country');

        $kba = null;

        $mainCategories = $this->sharedData['mainCategoriesWithParts'];

        $brands = $this->sharedData['carBrands'];

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
            ->with('carPartImages', function($query) {
                $query->whereNotNull('new_logo_german');
            })
            ->cursorPaginate(50);

        $partTypes = $this->sharedData['carPartTypes'];
        $dismantleCompanies = $this->sharedData['dismantleCompanies'];
        return view('car-parts.index', compact(
            'parts',
            'partTypes',
            'dismantleCompanies',
            'kba',
            'partsDifferentCarSameEngineType',
            'brands',
            'ditoNumber',
            'mainCategories'
        ));
    }

    public function searchParts(Request $request)
    {
        // Retrieve the search query, part type, sorting, and filters
        $search = $request->input('search');
        $sort = $request->query('sort');
        $filters = $request->input('filter', []);
        $partType = $request->query('type_id'); // Retrieve the part type filter
        $mainCategories = $this->sharedData['mainCategoriesWithParts'];

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
        ])->whereNull('country');


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
        $parts = $parts->cursorPaginate(50)->appends($request->query());

        // Fetch related data for dropdowns or filters, with caching
        $brands = $this->sharedData['carBrands'];

        $partTypes =  $this->sharedData['carPartTypes'];

        $dismantleCompanies = $this->sharedData['dismantleCompanies'];

        // Return the view with the filtered data
        return view('browse-car-parts', compact(
            'parts',
            'partTypes',
            'type',
            'dismantleCompanies',
            'brands',
            'mainCategories'
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
        $mainCategories = $this->sharedData['mainCategoriesWithParts'];

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
            paginate: 50
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

        $partTypes = $this->sharedData['carPartTypes'];

        // Return the view with the updated parts and search parameters
        return view('parts-kba', compact(
            'parts',
            'search',
            'partTypes',
            'type',
            'kba',
            'partCount',
            'mainCategories'
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

        $mainCategories = $this->sharedData['mainCategoriesWithParts'];

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
            paginate: 50
        );

        $parts = $results['data']['parts'];

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
        }

        // Prepare the search parameters for display and further actions
        $search = [
            'dito_number_id' => $request->get('dito_number_id'),
            'brand' => $request->get('brand'),
            'type_id' => $request->get('type_id'),
            'search' => $request->get('search'), // Secondary search term
        ];

        // Get all car part types
        $partTypes = $this->sharedData['carPartTypes'];

        return view('parts-model', compact(
            'parts',
            'search',
            'dito',
            'type',
            'partTypes',
            'mainCategories'
        ));
    }

    public function searchByOEM(Request $request, string $oem = null)
    {
        // If no route parameter, but OEM is present in query, redirect
        if (!$oem && $request->filled('oem')) {
            $redirectOem = $request->query('oem');
            $queryParams = $request->except('oem'); // Keep all others

            return redirect()->route('car-parts.search-by-oem', ['oem' => $redirectOem] + $queryParams);
        }

        $engine_code = $request->get('engine_code');
        $gearbox = $request->get('gearbox');
        $search = $request->query('search');
        $sort = $request->query('sort');
        $type_id = $request->query('type_id');

        $mainCategories = $this->sharedData['mainCategoriesWithParts'];

        $results = (new SearchByOeAction())->execute(
            oem: $oem,
            engine_code: $engine_code,
            gearbox: $gearbox,
            search: $search,
            sort: $sort,
            type_id: $type_id,
            paginate: 10,
        );

        $type = $request->filled('type_id') ? CarPartType::find($type_id) : null;
        $parts = $results['data']['parts'];
        $partTypes = $this->sharedData['carBrands'];

        return view('parts-oem', compact(
            'parts',
            'type',
            'oem',
            'engine_code',
            'gearbox',
            'partTypes',
            'mainCategories'
        ));
    }


    public function searchByNumberPlate()
    {

    }
}
