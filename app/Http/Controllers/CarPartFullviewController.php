<?php

namespace App\Http\Controllers;
use App\Models\CarBrand;
use App\Models\CarPartType;
use App\Models\DitoNumber;
use App\Models\NewCarPart;
use Illuminate\Http\Request;

class CarPartFullviewController extends Controller
{

    public function index(
        NewCarPart $part,
    ) {
        $part->load([
            'carPartImages' => function ($query) {
                $query->whereNotNull('new_logo_german');
            },
            'sbrCode',
            'ditoNumber',
            'carPartType'
        ]);

        $canonical = route('fullview', $part);

        if (request()->fullUrl() !== $canonical) {
            return redirect()->to($canonical, 301);
        }

        $breadcrumbs = $part->prepareCarPartBreadcrumbs();

        return view('car-part-fullview', compact(
            'part',
            'breadcrumbs',
        ));
    }


}
