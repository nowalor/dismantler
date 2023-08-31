<?php

namespace App\Services;

use App\Models\EngineType;
use App\Models\SbrCode;

class ResolveKbaFromSbrCodeService
{
    public function resolve(string $sbrCode, string $engineName): array
    {
        $sbrCodeModel = SbrCode::where('sbr_code', $sbrCode)->first();

        $engineTypes = EngineType::where('name', 'like', "%$engineName%")->get();

        if ($engineTypes->isEmpty()) {
            return [];
        }

        $engineTypeId = $engineType->id;

        $ditoNumbers = $sbrCodeModel->ditoNumbers()->whereHas('germanDismantlers', function ($query) use ($engineTypeId) {
            $query->whereHas('engineTypes', function ($query) use ($engineTypeId) {
                $query->where('engine_types.id', $engineTypeId);
            });
        })->with(['germanDismantlers' => function ($query) use ($engineTypeId) {
            $query->whereHas('engineTypes', function ($query) use ($engineTypeId) {
                $query->where('engine_types.id', $engineTypeId);
            });
        }])->get()
            ->pluck('germanDismantlers')->flatten()->unique();

        return $ditoNumbers->map(function ($ditoNumber) {
            return implode([
                'hsn' => $ditoNumber->hsn,
                'tsn' => $ditoNumber->tsn,
            ]);
        })->toArray();
    }
}

