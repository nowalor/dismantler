<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\View;
use App\Models\DitoNumber;

class AdminHomepageController extends Controller
{
    public function __invoke(Request $request)
    {
        $ditoNumbers = DitoNumber::where('is_selection_completed', 0);

        if($request->input('search') ) {
            $ditoNumber = $ditoNumbers
                ->where(function($query) use($request) {
                     $query->where('producer', 'like', '%' . $request->input('search') . '%');
                     $query->orWhere('brand', 'like', '%' . $request->input('search') . '%');
                });
        }

        $ditoNumbers = $ditoNumbers->paginate(50);
        return view('admin.index', compact('ditoNumbers'));
    }
}
