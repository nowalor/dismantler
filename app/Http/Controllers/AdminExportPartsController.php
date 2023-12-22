<?php

namespace App\Http\Controllers;

use App\Models\NewCarPart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminExportPartsController extends Controller
{
    public function __construct()
    {
    }

    /**￼
     * @throws Exception
     */
// "7143", "7302"],
    public function index(Request $request) // : View
    {
        $carPartsQuery = NewCarPart::with('carPartImages')
            ->whereNotNull('price_sek')
            ->where('price_sek', '>', 0)
            ->has('carPartImages')
//            ->where(function ($query) {
//                return $query->where('sbr_part_code', '7143')
//                    ->orWhere('sbr_part_code', '7302');
//            }) // electric engines
            ->whereNotNull('engine_code')
            ->where('engine_code', '!=', '')
//            ->whereHas('sbrCode.ditoNumbers.germanDismantlers.engineTypes')
            ->with('sbrCode.ditoNumbers.germanDismantlers.engineTypes')
            ->with('carPartImages');
//            ->where('dismantle_company_name', 'N');
//            ->where('car_part_type_id', 1); // Engines

        // Handle dismantle company filter
        if ($request->has('dismantle_company')) {
            $dismantleCompanyName = $request->get('dismantle_company');

            if ($dismantleCompanyName !== 'all') {
                $carPartsQuery->where('dismantle_company_name', $dismantleCompanyName);
            }
        }

        // Handle search
        if ($request->has('search')) {
            $search = $request->get('search');
            $carPartsQuery = $carPartsQuery->where(function ($carPart) use ($search) {

                $carPart->where('sbr_code_id', 'like', "%$search%")
                    ->orWhere('engine_code', 'like', "%$search%")
                    ->orWhere('name', 'like', "%$search%");
            });
        }

        $paginatedCarParts = $carPartsQuery->paginate(100)->withQueryString();

        // TODO get from DB
        $uniqueDismantleCompanyCodes = [
            "bo",
            'F',
            'A',
            'N',
            'S',
            'AL',
        ];

        $total = $paginatedCarParts->total();
        $filteredCarPartsCollection =
            $paginatedCarParts->getCollection()->filter(function ($carPart) use (&$total) {
                $myKbas = $carPart->my_kba;

                if ($myKbas->count() === 0) {
                    --$total;
                    return false;
                }

                $carPart->kba_string = implode(', ', $myKbas->map(function ($kbaNumber) {
                    return implode([
                        'hsn' => $kbaNumber->hsn,
                        'tsn' => $kbaNumber->tsn,
                    ]);
                })->toArray());

                return true;
            });

        $carParts = new LengthAwarePaginator(
            $filteredCarPartsCollection,
            $total,
            $paginatedCarParts->perPage(),
            $paginatedCarParts->currentPage(),
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('admin.export-parts.index', compact(
            'carParts',
            'uniqueDismantleCompanyCodes',
        ));
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
