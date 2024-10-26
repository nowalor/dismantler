<?php

namespace App\Http\Controllers;

use App\Models\CarPartType;
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

/*        if($request->input('search_by') === 'vin') {
            $apiURL .= '/vin';
        }*/

        $search = $request->input('search');

        $response = \Http::get("$apiURL/$search?api_token=$this->apiToken");

        $data =  $response->json()['data'];

        $ktype = Ktype::where('k_type', $data['ktype'])->first();

        if(!$ktype) {
            return 'fail, no ktype';
        }

        $carParts = $ktype->germanDismantlers()->with('newCarParts')->get()->pluck('newCarParts')->flatten();

        $parts = $carParts->filter(function ($carPart) use($data){
           return $carPart->engine_code && str_contains($data['extended']['engine_codes'], $carPart->engine_code);
        });

        $matchingPartsWithDifferentEngine = $carParts->filter(function ($carPart) use($data){
            return $carPart->engine_code && !str_contains($data['extended']['engine_codes'], $carPart->engine_code);
        });

        $partTypes = CarPartType::all();


        return view('plate-parts', compact('parts', 'partTypes'));
        //return view('searchByPlate', compact('matchingPartsWithDifferentEngine', 'filteredCarParts', 'data'));
    }
}
