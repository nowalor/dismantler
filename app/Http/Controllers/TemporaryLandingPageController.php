<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemporaryLandingPageController extends Controller
{
    public function TemporaryLandingPageView() {
        return view('TemporaryLandingPage');
    }
}
