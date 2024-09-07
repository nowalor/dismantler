<?php

namespace App\Console\Commands;

use App\Models\CarPart;
use App\Models\NewCarPart;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RemoveSoldPartsCommand extends Command
{
    protected $signature = 'remove:sold:parts';

    protected $description = 'Command description';


    public function handle()
    {
        ini_set('max_execution_time', 50000000);
        ini_set('max_input_time', 50000000);

        // We need to make a different API request for each dismantler we want parts from
        $dismantleCompanyIds = ['44', '50', '70'];

        foreach ($dismantleCompanyIds as $companyId) {
            for ($i = 0; $i < 199999; $i++) {
                $response = $this->fetchPage($i, $companyId);

                if (empty($response)) {
                    Log::info("Broke on page $i");
                    break;
                }

                $collectedResponse = collect($response);
                $partIdsFromAPI = $collectedResponse
             /*       ->whereIn('carItemTypeId', CarPart::CAR_PART_TYPE_IDS_TO_INCLUDE)
                    ->all()*/
                    ->pluck('id');

                    foreach($$partIdsFromAPI as $partId) {
                        $part = NewCarPart::where('original_id', $partId)->first();

                        if(!$part) {
                            continue;
                        }

                        $this->info($part);
                    }
            }
        }


        $this->info('Finished removing sold parts');
        return Command::SUCCESS;
    }


    private function fetchPage(int $page, string $companyId)
    {
        $apiKey = config()->get('app.egluit_api_key');
        $url = 'https://v2-cloud.egluit.dk/gql/graphql';

        $variables = [
            'input' => [
                'companyId' => 44,
                'dateHourBack' => null,
                'maxRows' => 1000000000,
                'pageNumber' => $page,
                'pageSize' => 1000,
                'pageSort' => null
            ]
        ];

        $query = 'query marcusDeletePartsSearch($input: MarcusPartsSearchInput!) { marcusDeletePartsSearch(input: $input) { totalRows items { id companyId itemNumber carItemNumber dateTimeModified } } }';

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
