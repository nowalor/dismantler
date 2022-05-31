<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\View;
use App\Models\DitoNumber;

class AdminHomepageController extends Controller
{
    public function __invoke()
    {
        $ditoNumbers = DitoNumber::paginate(50);

        return view('admin.index', compact('ditoNumbers'));
    }
}
