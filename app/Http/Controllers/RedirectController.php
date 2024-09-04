<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirectToModifiedUrl(Request $request)
    {
        // Parse the current URL to modify the query parameters
        $queryParams = $request->query();

        // Add or replace the desired query parameter
        // For example, add or replace the 'new_param' query parameter with 'new_value'
        $queryParams['new_param'] = 'new_value';

        // Generate the new URL with the updated query parameters
        $newUrl = url()->current() . '?' . http_build_query($queryParams);

        // Redirect to the new URL
        return redirect($newUrl);
    }
}
