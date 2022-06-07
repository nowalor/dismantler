<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\View;
use App\Models\DitoNumber;

class AdminHomepageController extends Controller
{
    public function __invoke(Request $request)
    {
        $ditoNumbers;

        if($request->query('filter') == 'uninteresting') {
            $ditoNumbers = DitoNumber::where('is_not_interesting', 1);
        } else if($request->query('filter') == 'completed') {
            $ditoNumbers = DitoNumber::where('is_selection_completed', 1);
        } else {
            $ditoNumbers = DitoNumber::where('is_selection_completed', 0)->where('is_not_interesting', 0);
        }

        if($request->input('search') ) {
            $ditoNumber = $ditoNumbers
                ->where(function($query) use($request) {
                     $query->where('producer', 'like', '%' . $request->input('search') . '%');
                     $query->orWhere('brand', 'like', '%' . $request->input('search') . '%');
                });
        }

        $ditoNumbers = $ditoNumbers->paginate(50)->withQueryString();
        return view('admin.index', compact('ditoNumbers'));
    }
}
