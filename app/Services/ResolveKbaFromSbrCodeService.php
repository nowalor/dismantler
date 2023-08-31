<?php

namespace App\Services;

use App\Models\SbrCode;

class ResolveKbaFromSbrCodeService
{
    public function resolve(string $sbrCode, string $engineName): array
    {
        $sbrCodeModel = SbrCode::where('sbr_code', $sbrCode)->first();

        $sbrCodeModel->load(['ditoNumbers.germanDismantlers' => function ($query) use ($engineName) {
            $query->whereHas('engineTypes', function ($query) use ($engineName) {
                $query->where('name', 'like', "%$engineName%");
            });
        }]);

        $uniqueKba = $sbrCodeModel->ditoNumbers->pluck('germanDismantlers')->flatten()->unique();

       return $uniqueKba->map(function($kba) {
           return implode([
               'hsn' => $kba->hsn,
               'tsn' => $kba->tsn,
           ]);
       });
    }
}

