<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterBrowsingCountryRequest;

class BrowsingCountryController extends Controller
{
    public function filter(FilterBrowsingCountryRequest $request): mixed
    {

        $validated = $request->validated();

        if ($validated) {
            session(['browsing_country' => $request->input('country')]);
        } else {
            $request->messages();
        }


        return back();
    }
}
