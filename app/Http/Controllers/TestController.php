<?php

namespace App\Http\Controllers;

use App\Models\CarPart;
use App\Models\NewCarPart;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Models\GermanDismantler;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function testingParts()
    {
        $parts = NewCarPart::with('carPartImages')->whereNotNull('price_sek')
            ->where('price_sek', '>', 0)
            ->whereNotNull('engine_code')
            ->where('engine_code', '!=', '')
            // ->where('dismantle_company_name', 'F')
            ->whereHas('sbrCode.ditoNumbers.germanDismantlers.engineTypes')
            ->with('sbrCode.ditoNumbers.germanDismantlers.engineTypes')
            ->whereNull('sold_at')
            ->get();

        foreach ($parts as $index => $part) {
            if(count($part->my_kba) === 0) {
                $parts->forget($index);
                continue;
            }
        }

        return $parts->count();
    }

    public function showSelectPage()
    {
        return view('select-page');
    }

    public function showGermanDismantlers()
    {
        $dismantlers = GermanDismantler::paginate(20);

        return view('german-dismantlers', compact('dismantlers'));
    }

    public function showDanishDismantlers()
    {
        $dismantlers = GermanDismantler::all();

        return view('danish-dismantlers', compact('dismantlers'));
    }

    public function carPartIds()
    {
        ini_set('max_execution_time', 50000000);
        ini_set('max_input_time', 50000000);

        // We need to make a different API request for each dismantler we want parts from
        $dismantleCompanyIds = ['44', '50', '70'];
        $partIds = [];

        foreach ($dismantleCompanyIds as $companyId) {
            for ($i = 0; $i < 199999; $i++) {
                $response = $this->fetchPage($i, $companyId);

                if (empty($response)) {
                    Log::info("Broke on page $i");
                    break;
                }

                $collectedResponse = collect($response);
                $partIdsFromAPI = $collectedResponse
                    ->whereIn('itemTypeId', CarPart::CAR_PART_TYPE_IDS_TO_INCLUDE)
                    ->pluck('id')
                    ->toArray();

                $test = CarPart::take(15)->pluck('id');

                return [
                    'db' => $test,
                    'api' => $partIdsFromAPI
                ];

               array_merge($partIds, $partIdsFromAPI);


            }
        }

        $partIdsFromDB = CarPart::withoutGlobalScopes()->get()->pluck('id')->toArray();

        $partsSold = array_diff($partIdsFromDB, $partIds);

        return [
            'parts_sold_count' => count($partsSold),
            'parts_sold' => $partIdsFromDB,
        ];
    }


    private function fetchPage(int $page, string $companyId)
    {
        $apiKey = config()->get('app.egluit_api_key');
        $url = 'https://v2-cloud.egluit.dk/gql/graphql';

        $variables = [
            'input' => [
                'companyId' => $companyId,
                'dateHourBack' => null,
                'maxRows' => 1000000000,
                'pageNumber' => $page,
                'pageSize' => 1000,
                'pageSort' => null
            ]
        ];

        $query = 'query ($input: MarcusPartsSearchInput!) { marcusPartsSearch(input: $input) { totalRows items { id itemPartId companyId itemTypeId carItemTypeId itemNumber carItemNumber itemCode condition oemNumber shelfNumber warehouseInputDate price1 price2 price3 comments notes carBody carVinCode engineCode carTypeApprovalNo carTypeApprovalDate engineType kilometrage year dateTimeCreated dateTimeModified status images { originUrl thumbnail120Url } name quantity carFirstRegistrationDate carDoorsType registrationNo kiloWatt transmissionType transmissionCode equipmentModel bodyColor interiorColor type euroNorm insuranceNumber insurancePrice insuranceTxt readOnPart alternativeNumbers } } }';

        $response = Http::withOptions(['verify' => false])->withHeaders([
            'Authorization' => "x-api-key $apiKey",
            'Content-Type' => 'application/json'
        ])->post($url, [
            'variables' => $variables,
            'query' => $query,
        ]);

        return $response['data']['marcusPartsSearch']['items'];
    }

}
