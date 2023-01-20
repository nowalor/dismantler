<?php

namespace App\Http\Controllers;

use App\Models\CarPart;
use App\Models\DitoNumber;
use App\Models\EngineType;
use Illuminate\Http\Request;

class MissingInformationController extends Controller
{
    public function index()
    {
        $carPartDitoNumbers = CarPart::distinct('ditoNumberFromItemCode')
            ->get()
            ->pluck('ditoNumberFromItemCode');

        $ditoNumbers = DitoNumber::pluck('dito_number');

        $carPartDitoNumbersNotInTable =
            $carPartDitoNumbers->diff($ditoNumbers);

        $ditoNumbers =  CarPart::get()
            ->whereIn('ditoNumberFromItemCode', $carPartDitoNumbersNotInTable)
            ->countBy('ditoNumberFromItemCode');

        return view('admin.information.index', compact('ditoNumbers'));
    }

    public function show($ditoNumber)
    {
        $carParts = CarPart::get()->where('ditoNumberFromItemCode', $ditoNumber);

        return view('admin.information.show', compact('carParts', 'ditoNumber'));
    }
}
