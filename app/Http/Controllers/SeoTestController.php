<?php

namespace App\Http\Controllers;

use App\Models\NewCarPart;
use Illuminate\Http\Request;

class SeoTestController extends Controller
{
    public function __invoke(NewCarPart $carPart)
    {
        return route('car-parts.show-test', $carPart);
    }
}
