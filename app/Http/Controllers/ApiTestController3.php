<?php

namespace App\Http\Controllers;

use App\Models\CarPart;
use Illuminate\Http\Request;

class ApiTestController3 extends Controller
{
    //

    public function __invoke(): mixed
    {
        return CarPart::where('engine_code', 'BLS')
            ->has('ditoNumber')
            ->with('ditoNumber.germanDismantlers')
            ->get()
            ->pluck('ditoNumber');
    }
}
