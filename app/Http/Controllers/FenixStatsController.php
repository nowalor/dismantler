<?php

namespace App\Http\Controllers;

use App\Models\NewCarPart;
use Illuminate\Support\Facades\DB;

class FenixStatsController extends Controller
{
    public function index()
    {
        $aggregates = NewCarPart::selectRaw("
            SUM(CASE WHEN fields_resolved_at IS NOT NULL THEN 1 ELSE 0 END) AS resolved_parts,
            SUM(CASE WHEN fields_resolved_at IS NOT NULL AND article_nr IS NOT NULL THEN 1 ELSE 0 END) AS sellable_parts,
            SUM(CASE WHEN fields_resolved_at IS NOT NULL AND article_nr IS NULL THEN 1 ELSE 0 END) AS unsellable_parts
        ")->first();

        $unSellablePartTypeCounts = NewCarPart::whereNotNull('fields_resolved_at')
            ->whereNull('article_nr')
            ->distinct()
            ->count('sbr_part_code');

        $sellablePartTypeCount = NewCarPart::whereNotNull('fields_resolved_at')
            ->whereNotNull('article_nr')
            ->distinct()
            ->count('car_part_type_id');

        $sellablePartsWithProcessedImage = NewCarPart::whereNotNull('fields_resolved_at')
            ->whereNotNull('article_nr')
            ->whereHas('carPartImages', function($query) {
                $query->whereNotNull('new_logo_german');
            })
            ->count();

        $stats = [
            'resolvedParts' => $aggregates->resolved_parts,
            'sellableParts' => $aggregates->sellable_parts,
            'unSellableParts' => $aggregates->unsellable_parts,
            'sellable' => $sellablePartsWithProcessedImage,
            'unSellablePartTypeCounts' => $unSellablePartTypeCounts,
            'sellablePartTypeCount' => $sellablePartTypeCount,
        ];

        return view('admin.fenix.stats', compact('stats'));
    }

    /*
     * Show a list of part types we should add to our excel to be able to sell
     */
    public function partTypes()
    {
        $unSellablePartTypes = NewCarPart::whereNotNull('fields_resolved_at')
            ->whereNull('article_nr')
            ->select('sbr_part_code', DB::raw('COUNT(*) as count'))
            ->groupBy('sbr_part_code')
            ->orderByDesc('count')
            ->get();

        return $unSellablePartTypes;

        return view('admin.fenix.part-types');
    }

    /*
    * Show a list of part types we should add to our excel to be able to sell
    */
    public function partTypesWeHave()
    {
        $unSellablePartTypes = NewCarPart::whereNotNull('fields_resolved_at')
            ->with('carPartType')
            ->whereNotNull('article_nr')
            ->select('car_part_type_id', DB::raw('COUNT(*) as count'))
            ->groupBy('car_part_type_id')
            ->orderByDesc('count')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->carPartType->name ?? 'Unknown' => $item->count];
            });

        return $unSellablePartTypes;

        return view('admin.fenix.part-types');
    }
}
