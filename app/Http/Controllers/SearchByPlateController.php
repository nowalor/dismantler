<?php

namespace App\Http\Controllers;

use App\Models\KType;
use Illuminate\Http\Request;

class SearchByPlateController extends Controller
{
    private string $apiUrl;
    private string $apiToken;

    public function __construct()
    {
        $this->apiUrl = config('services.nummerplade.api_url');
        $this->apiToken = config('services.nummerplade.token');
    }

    public function __invoke()
    {
        return view('searchByPlate');
    }

    public function search(Request $request)
    {
        if(!$request->has('search')) {
            return 'Missing search';
        }

        $apiURL = $this->apiUrl;

        if($request->input('search_by') === 'vin') {
            $apiURL .= '/vin';
        }

        $search = $request->input('search');

        $response = \Http::get("$apiURL/$search?api_token=$this->apiToken");

        $ktpye =  $response->json()['data']['ktype'];

        $ktype = Ktype::where('k_type', $ktpye)->first();

        $carParts = $ktype->germanDismantlers()->with('newCarParts')->get()->pluck('newCarParts')->flatten();

        return view('searchByPlate', compact('carParts'));
    }
}
