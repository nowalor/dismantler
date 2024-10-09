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

        $data =  $response->json()['data'];

        $ktype = Ktype::where('k_type', $data['ktype'])->first();

        $carParts = $ktype->germanDismantlers()->with('newCarParts')->get()->pluck('newCarParts')->flatten();

        $filteredCarParts = $carParts->filter(function ($carPart) use($data){
           return str_contains($data['engine_code'], $carPart->engine_code);
        });

        return view('searchByPlate', compact('carParts', 'filteredCarParts'));
    }
}
