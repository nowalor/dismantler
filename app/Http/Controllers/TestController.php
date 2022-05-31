<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GermanDismantler;

class TestController extends Controller
{
    public function showSelectPage()
    {
        return view('select-page');
    }

    public function showGermanDismantlers()
    {
        $dismantlers = GermanDismantler::paginate(20);

        return view('german-dismantlers', compact('dismantlers'));
    }

    public function showDanishDismantlers()
    {
        $dismantlers = GermanDismantler::all();

        return view('danish-dismantlers', compact('dismantlers'));
    }

}
