<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterBrowsingCountryRequest;
use Illuminate\Http\RedirectResponse;

class BrowsingCountryController extends Controller
{
    public function filter(FilterBrowsingCountryRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        session(['browsing_country' => $validated['country']]);

        return back();
    }
}
