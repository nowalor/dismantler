<?php

namespace App\Http\Controllers;

use App\Models\NewCarPart;
use Illuminate\Http\Request;

class FenixStatsController extends Controller
{
    public function index()
    {
        $resolvedParts = NewCarPart::whereNotNull('fields_resolved_at')->count();
        $sellableParts = NewCarPart::whereNotNull('fields_resolved_at')
            ->whereNotNull('article_nr')
            ->count();
        $unSellableParts = NewCarPart::whereNotNull('fields_resolved_at')
            ->whereNull('article_nr')
            ->count();

        $unSellablePartTypes = NewCarPart::whereNotNull('fields_resolved_at')
            ->whereNull('article_nr')
            ->select('sbr_part_code')
            ->distinct()
            ->pluck('sbr_part_code');

        $unSellablePartTypeCounts = NewCarPart::whereNotNull('fields_resolved_at')
            ->whereNull('article_nr')
            ->select('sbr_part_code')
            ->distinct()
            ->count('sbr_part_code');

        $resolvedPartsWithProcessedImages = NewCarPart::with('carPartImages')
            ->whereNotNull('fields_resolved_at')
            ->whereNotNull('article_nr')
            ->whereHas('carPartImages', function($query) {
                $query->whereNotNull('new_logo_german');
            })->count();

        return [
            'resolvedParts' => $resolvedParts,
            'sellableParts' => $sellableParts,
            'unSellableParts' => $unSellableParts,
     /*       'unSellablePartTypes' => $unSellablePartTypes,*/
            'resolvedPartsWithProcessedImages' => $resolvedPartsWithProcessedImages,
            'unSellablePartTypeCounts ' => $unSellablePartTypeCounts,
        ];
    }
}
