<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function __invoke()
    {
        return view('homepage');
    }
}
