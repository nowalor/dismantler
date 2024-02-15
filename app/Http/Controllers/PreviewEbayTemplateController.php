<?php

namespace App\Http\Controllers;

use App\Models\NewCarPart;
use Illuminate\View\View;

class PreviewEbayTemplateController extends Controller
{
    public function __invoke(NewCarPart $carPart): View
    {
        return view('ebay-preview', compact('carPart'));
    }
}
