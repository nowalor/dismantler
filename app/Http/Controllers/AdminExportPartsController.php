<?php

namespace App\Http\Controllers;

use App\Models\NewCarPart;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AdminExportPartsController extends Controller
{
    public function index()
    {
        $carParts = NewCarPart::with('carPartImages')
            ->get();


        foreach ($carParts as $index => $carPart) {
            $engineCode = $carPart->engine_code;

            $carPart->load(['sbrCode.ditoNumbers.germanDismantlers' => function ($query) use ($engineCode) {
                $query->whereHas('engineTypes', function ($query) use ($engineCode) {
                    $query->where('name', '=', $engineCode);
                });
            }]);

            $uniqueKba = $carPart->sbrCode->ditoNumbers->pluck('germanDismantlers')->flatten()->unique();

            if ($uniqueKba->isEmpty()) {
                $carParts->forget($index);
                continue; // Skip car parts without KBA numbers
            }

            $carPart->kba = $uniqueKba;
            $carPart->kba_string = implode(', ', $uniqueKba->map(function ($kbaNumber) {
                return implode([
                    'hsn' => $kbaNumber->hsn,
                    'tsn' => $kbaNumber->tsn,
                ]);
            })->toArray());

        }
        
        return view('admin.export-parts.index', compact('carParts'));
    }

    public function show(NewCarPart $carPart)
    {

        $carPart->load('carPartImages');
        $engineCode = $carPart->engine_code;

        $carPart->load(['sbrCode.ditoNumbers.germanDismantlers' => function ($query) use ($engineCode) {
            $query->whereHas('engineTypes', function ($query) use ($engineCode) {
                $query->where('name', '=', $engineCode);
            });
        }]);

        $uniqueKba = $carPart->sbrCode->ditoNumbers->pluck('germanDismantlers')->flatten()->unique();
        $carPart->kba = $uniqueKba;
        $carPart->kba_string = implode(', ', $uniqueKba->map(function ($kbaNumber) {
            return implode([
                'hsn' => $kbaNumber->hsn,
                'tsn' => $kbaNumber->tsn,
            ]);
        })->toArray());

        return view('admin.export-parts.show', compact('carPart'));
    }

    private function getKba(NewCarPart $carPart): array
    {
        $engineCode = $carPart->engine_code;

        $kba = [];
        $carPart->sbrCode->ditoNumbers->each(function ($ditoNumber) use (&$kba, $engineCode) {

        });

        $kba = array_unique($kba);
        return $kba;
    }

    private function getKbaString(array $kba): string
    {
        return implode(', ', array_map(function ($kbaNumber) {
            return implode([
                'hsn' => $kbaNumber[0]->hsn,
                'tsn' => $kbaNumber[0]->tsn,
            ]);
        }, $kba));
    }
}
