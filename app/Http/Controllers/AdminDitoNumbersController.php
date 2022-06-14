<?php

namespace App\Http\Controllers;

use App\Models\DitoNumber;
use App\Models\GermanDismantler;
use App\Models\ManufacturerText;
use App\Models\CommercialName;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class AdminDitoNumbersController extends Controller
{

    public function index(Request $request)
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(DitoNumber $ditoNumber, Request $request)
    {
        $germanDismantlers = GermanDismantler::whereDoesntHave(
                   'ditoNumbers',
                   fn($query) => $query->where('id', $ditoNumber->id)
               );

               if($request->filled('sort_by')) {
                   $germanDismantlers->orderBy($request->input('sort_by'));
               }

               if($request->filled('date_from')) {
                   $fromDate = Carbon::parse($request->input('date_from'));
                   $germanDismantlers
                       ->where('date_of_allotment', '>=', $fromDate);

               }

               if($request->filled('date_to')) {
                   $toDate = Carbon::parse($request->input('date_to'));
                   $germanDismantlers
                       ->where('date_of_allotment', '<=', $toDate);
              }

               $plaintexts = ManufacturerText::all();
               $commercialNames = CommercialName::all();

               $relatedDismantlers = $ditoNumber->germanDismantlers;

               if($request->filled('plaintext')) {
                   $germanDismantlers->where('manufacturer_plaintext', 'like', '%' . $request->input('plaintext') . '%');
               }

               if($request->filled('commercial_name')) {
                   $germanDismantlers->where('commercial_name', 'like', '%' . $request->input('commercial_name') . '%');
               }

               if($request->filled('make')) {
                   $germanDismantlers->where('make', 'like', '%'  . $request->input('make') . '%');
               }

               $germanDismantlers = $germanDismantlers->paginate(250)->withQueryString();
               $request->flash();

               return view('admin.dito-numbers.show',
                   compact('ditoNumber', 'germanDismantlers', 'relatedDismantlers', 'plaintexts', 'commercialNames')
               );
    }

    public function edit(DitoNumber $ditoNumber)
    {
        //
    }

    public function update(Request $request, DitoNumber $ditoNumber)
    {

        if($request->filled('is_selection_completed')) {
            $ditoNumber->is_selection_completed = $request->input('is_selection_completed');
        }

         if($request->filled('is_not_interesting')) {
            $ditoNumber->is_not_interesting = $request->input('is_not_interesting');
        }

        if($ditoNumber->isDirty()) {
            $ditoNumber->save();
        }

        return redirect()->route('admin.index');
    }

    public function destroy(DitoNumber $ditoNumber)
    {
        //
    }
}
