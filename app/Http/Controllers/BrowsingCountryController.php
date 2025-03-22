<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrowsingCountryController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'country' => 'required|string|in:da,de,fr,pl,sv', // only allowed countries
        ]);

        session(['browsing_country' => $request->input('country')]);

        return back();
    }
}
