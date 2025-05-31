<?php

namespace App\Http\Controllers;

use App\Models\CarPartType;
use App\Models\KType;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class SearchByPlateController extends BaseController
{
    private string $apiUrl;
    private string $apiToken;

    public function __construct()
    {
        $this->apiUrl = config('services.nummerplade.api_url');
        $this->apiToken = config('services.nummerplade.token');
        parent::__construct();
    }

    public function __invoke()
    {
        return view('searchByPlate', compact('mainCategories'));
    }

    public function search(Request $request)
    {
        if(!$request->has('search')) {
            return 'Missing search';
        }

        $apiURL = $this->apiUrl;

        $search = $request->input('search');
        $response = \Http::get("$apiURL/$search?api_token=$this->apiToken");

        $data =  $response->json()['data'];
        $ktype = Ktype::where('k_type', $data['ktype'])->first();

        if(!$ktype) {
            return 'fail, no ktype';
        }

        // Handle pagination
        $perPage = 10; // Number of items per page
        $page = $request->get('page', 1); // Get current page
        $offset = ($page - 1) * $perPage;

        // Retrieve car parts with pagination
        $carPartsQuery = $ktype->germanDismantlers()->with('newCarParts', function($q) {
            $q->where('country', 'da');
        })->get()->pluck('newCarParts')->flatten();

        $engineCode = $data['extended']['engine_codes'];
        $normalizedEngineCode = str_replace(' ', '', $engineCode);

        $filteredCarParts = $carPartsQuery->filter(function ($carPart) use ($data, $normalizedEngineCode) {
            return $carPart->engine_code && str_contains($normalizedEngineCode, $carPart->engine_code);
        });

        // Paginate the results manually
        $parts = $filteredCarParts->slice($offset, $perPage)->values();
        $parts = new \Illuminate\Pagination\LengthAwarePaginator($parts, $filteredCarParts->count(), $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        $partTypes = $this->sharedData['carPartTypes'];
        $mainCategories = $this->sharedData['mainCategories'];

        return view('plate-parts', compact('parts', 'partTypes', 'mainCategories'));
    }

}
