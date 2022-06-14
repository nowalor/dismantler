<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\View;
use App\Models\DitoNumber;

class AdminHomepageController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('admin.index');
    }
}
