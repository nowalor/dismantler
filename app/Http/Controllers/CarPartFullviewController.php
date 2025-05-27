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
            'carPartImages',
            'sbrCode',
            'ditoNumber',
            'carPartType'
        ]);

        $canonical = route('fullview', $part);

        if (request()->fullUrl() !== $canonical) {
            return redirect()->to($canonical, 301);
        }

        $breadcrumbs = $part->prepareCarPartBreadcrumbs();
        $relevantParts = $part->findRelevantParts();

        return view('car-part-fullview', compact(
            'part',
            'breadcrumbs',
            'relevantParts',
        ));
    }


}
