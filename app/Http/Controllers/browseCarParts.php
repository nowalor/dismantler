<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrowseCarParts extends Controller
{
    public function browseCarParts() {
        return view ('browse-car-parts');
    }
}
