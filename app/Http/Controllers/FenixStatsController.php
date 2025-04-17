<?php

namespace App\Http\Controllers;

use App\Models\NewCarPart;

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
        ];

        return view('admin.fenix.stats', compact('stats'));
    }

}
