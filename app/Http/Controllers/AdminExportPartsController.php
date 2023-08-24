<?php

namespace App\Http\Controllers;

use App\Models\NewCarPart;
use App\Services\CalculatePriceService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminExportPartsController extends Controller
{
    public function __construct(private CalculatePriceService $calculatePriceService)
    {
    }

    /**
     * @throws \Exception
     */
    public function index(Request $request) // : View
    {
        $carParts = NewCarPart::with('carPartImages')
            ->with('sbrCode.ditoNumbers.germanDismantlers.engineTypes')
            ->get();

        foreach($carParts as $index => $carPart) {

            $carPart->calculated_price = $this->calculatePriceService->sekToEurForFenix
            (
                $carPart->price_sek,
                $carPart->car_part_type_id
            );


            $uniqueKba = $carPart->sbrCode->ditoNumbers->pluck('germanDismantlers')->flatten()->unique();

            $engineCode = $carPart->engine_code;

            foreach($uniqueKba as $kba) {
                // Remove kba numbers that don't have the engine code
                if(!$kba->engineTypes->contains('name', $engineCode)) {
                    $uniqueKba = $uniqueKba->reject(function ($kbaNumber) use ($kba) {
                        return $kbaNumber->id === $kba->id;
                    });
                }
            }
            if($uniqueKba->isEmpty()) {
                $carParts->forget($index);
                continue;
            }

            $carPart->kba = $uniqueKba;
            $carPart->kba_string = implode(', ', $carPart->kba->map(function ($kbaNumber) {
                return implode([
                    'hsn' => $kbaNumber->hsn,
                    'tsn' => $kbaNumber->tsn,
                ]);
            })->toArray());
        }

        if($request->has('search')) {
            $search = $request->get('search');
            $carParts = $carParts->filter(function ($carPart) use ($search) {
                $match = false;
                if (str_contains(strtolower($carPart->name), strtolower($search))) {
                    $match = true;
                }

                if (str_contains(strtolower($carPart->kba_string), strtolower($search))) {
                    $match = true;
                }

                if (str_contains(strtolower($carPart->sbrCode->name), strtolower($search))) {
                    $match = true;
                }

                if (str_contains(strtolower($carPart->engine_code), strtolower($search))) {
                    $match = true;
                }

                return $match;
            });
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
