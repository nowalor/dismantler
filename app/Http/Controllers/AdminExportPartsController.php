<?php

namespace App\Http\Controllers;

use App\Models\NewCarPart;
use Illuminate\Http\Request;

class AdminExportPartsController extends Controller
{
    public function index()
    {
        $carParts = NewCarPart::with('carPartImages')->paginate(40);

        return view('admin.export-parts.index', compact('carParts'));
    }
}
