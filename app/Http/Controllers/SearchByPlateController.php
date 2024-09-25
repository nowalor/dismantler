<?php

namespace App\Http\Controllers;

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

        $search = $request->input('search');

        $response = \Http::get("$this->apiUrl/$search?api_token=$this->apiToken");

        $data =  $response->json()['data'];

        return $data['ktype'];

        return $request->input('search');
    }
}
