<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use App\Models\MainCategory;
use App\Models\CarPartType;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $partTypes = CarPartType::all();
        $mainCategories = MainCategory::all();

        return view('admin.part-types-categories.index', compact(
            'partTypes',
            'mainCategories',
        ));
    }

    public function show($id)
    {
        $mainCategory = MainCategory::findOrFail($id);

        // Get connected car part types
        $connectedCarPartTypes = $mainCategory->carPartTypes;

        // Get unconnected car part types
        $unconnectedCarPartTypes = CarPartType::whereDoesntHave('mainCategories', function ($query) use ($mainCategory) {
            $query->where('main_categories.id', $mainCategory->id); // Specify the table name
        })->get();

        return view('admin.part-types-categories.show', compact(
            'mainCategory',
            'connectedCarPartTypes',
            'unconnectedCarPartTypes'
        ));
    }


    public function connectCarPart(MainCategory $mainCategory, Request $request)
    {
        $carPartTypeId = $request->input('car_part_type_id');

        if (!$mainCategory->carPartTypes()->where('car_part_types.id', $carPartTypeId)->exists()) { // Specify the table name
            $mainCategory->carPartTypes()->attach($carPartTypeId);
            return redirect()->back()->with('connection-saved', 'Car part type connected successfully.');
        }

        return redirect()->back()->with('error', 'Car part type is already connected.');
    }

    public function disconnectCarPart(MainCategory $mainCategory, Request $request)
    {
        $carPartTypeId = $request->input('car_part_type_id');

        if ($mainCategory->carPartTypes()->where('car_part_types.id', $carPartTypeId)->exists()) {
            $mainCategory->carPartTypes()->detach($carPartTypeId);
            return redirect()->back()->with('connection-deleted', 'Car part type disconnected successfully.');
        }

        return redirect()->back()->with('error', 'Car part type is not connected.');
    }


    public function getConnectedCarParts(MainCategory $mainCategory)
    {
        return response()->json($mainCategory->carPartTypes);
    }

}
