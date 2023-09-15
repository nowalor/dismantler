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

    /**￼
     * @throws \Exception
     */
    public function index(Request $request) // : View
    {
        $carParts = NewCarPart::with('carPartImages')
            ->whereNotNull('price_sek')
            ->where('price_sek', '>', 0)
            ->whereNotNull('engine_code')
            ->where('engine_code', '!=', '')
            ->whereHas('sbrCode.ditoNumbers.germanDismantlers.engineTypes')
            ->with('sbrCode.ditoNumbers.germanDismantlers.engineTypes')
            ->with('carPartImages')
            ->paginate(100);

        // TODO get from DB
        $uniqueDismantleCompanyCodes = [
            "bo",
            'F',
        ];

        foreach($carParts as $index => $carPart) {
            $carPart->calculated_price = $this->calculatePriceService->sekToEurForFenix
            (
                $carPart->price_sek,
                $carPart->car_part_type_id
            );

            $myKbas = $carPart->my_kba;
            if(count($myKbas) === 0) {
                $carParts->forget($index);
                continue;
            }

            $carPart->kba_string = implode(', ', $myKbas->map(function ($kbaNumber) {
                return implode([
                    'hsn' => $kbaNumber->hsn,
                    'tsn' => $kbaNumber->tsn,
                ]);
            })->toArray());
        }

        // Handle search
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

        // Handle dismantle company filter
        if($request->has('dismantle_company_code')) {
            $dismantleCompanyCode = $request->get('dismantle_company_code');


            if($dismantleCompanyCode !== 'all') {
                $carParts = $carParts->filter(function ($carPart) use ($dismantleCompanyCode) {
                    return $carPart->dismantle_company_code === $dismantleCompanyCode;
                });
            }
        }

        return view('admin.export-parts.index', compact(
            'carParts',
            'uniqueDismantleCompanyCodes')
        );
    }

    public function show(NewCarPart $carPart)
    {

        $carPart->load('carPartImages');

        $carPart->kba_string = implode(', ', $carPart->my_kba->map(function ($kbaNumber) {
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
