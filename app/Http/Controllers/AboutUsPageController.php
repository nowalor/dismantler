<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AboutUsPageController extends Controller
{
    public function __invoke(): View
    {
        return view('about-us.index');
    }
}
