<?php

namespace App\Console\Commands;

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

        $data = [];

        $dismantleCompanyIds = ['44', '50', '70'];

        foreach ($dismantleCompanyIds as $companyId) {
            for ($i = 0; $i < 199999; $i++) {
                $response = $this->fetchPage($i, $companyId);

                if (empty($response)) {
                    Log::info("Broke on page $i");
                    break;
                }

                foreach ($response as $item) {
                    array_push($data, $item['id']);
                }

            }
        }

        Log::info('------- THE DATA -------');
        Log::info(json_encode($data));

        return Command::SUCCESS;

        // $carParts = CarPart::all();
        // foreach($carParts as $carPart) {
        // if(!in_array($data,  $carPart->id)) {
        // $carPart->delete();
        // }
    // }
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
