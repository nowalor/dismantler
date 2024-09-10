<?php

namespace App\Console\Commands;

use App\Models\DanishCarPartType;
use App\Models\NewCarPart;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SeedGermanCarPartsCommand extends Command
{
    protected $signature = 'german:parts:seed';
    protected $description = 'Seed parts from German dismantlers on a schedule';

    private function transformSingle($item)
    {
        $newItem = [];

        $ditoNumber = DanishCarPartType::where('egluit_id', $item['itemTypeId'])->first()?->code;

        $companyMap = [
         /*   '44' => 'AA',
            '50' => 'BB',*/
            '70' => 'CC'
        ];

        $newItem['id'] =  1567 . (int)$item['id'];
        $newItem['dismantle_company_name'] = $companyMap[$item['companyId']] ?? null;
        $newItem['country'] = 'DK';
        $newItem['original_id'] = (int)$item['id'];
        $newItem['external_dismantle_company_id'] = $item['companyId'];
        $newItem['name'] = $item['name'];
        $newItem['quantity'] = $item['quantity'];
        $newItem['price_dkk'] = $item['price2'];
        $newItem['quality'] = $item['condition'];
        $newItem['article_nr_at_dismantler'] = $item['id'];
        $newItem['original_number'] = $item['oemNumber'];
        $newItem['model_year'] = $item['year'];
        $newItem['data_provider_id'] = 3;
        $newItem['dito_number'] = $ditoNumber;
        $newItem['external_part_type_id'] = $item['itemTypeId'];
        $newItem['danish_item_code'] = $item['itemCode'];
        $newItem['vin'] = $item['carVinCode'];
        $newItem['engine_code'] = $item['engineCode'];
        $newItem['engine_type'] = $item['engineType'];
        $newItem['mileage_km'] = $item['kilometrage'] * 1000;
        $newItem['mileage'] = $item['kilometrage'];
        $newItem['carPartImages'] = $this->transformImages($item['images']);

        return $newItem;
    }

    public function handle()
    {
        ini_set('max_execution_time', 0);
        ini_set('max_input_time', 0);

        $dismantleCompanyIds = [
            '70',
            '50',
            '44'
        ];

        foreach ($dismantleCompanyIds as $companyId) {
            try {
                $page = 0;
                while (true) {
                    $response = $this->fetchPage($page, $companyId);

                    if (empty($response)) {
                        Log::info("Broke on page $page");

                        $this->info("Broke on page $page");

                        break;
                    }

                    $transformedData = $this->transformData($response);

                    $this->batchInsert($transformedData);

                    $page++;
                }
            } catch (Exception $ex) {
                Log::info($ex->getMessage());

                $this->info('IN CATCH:');
                $this->info($ex->getMessage());

                return 'in catch';
            }
        }
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


    private function transformData(array $data): array
    {
        return array_map([$this, 'transformSingle'], $data);
    }

    private function transformImages(array $images): array
    {
        return collect($images)->filter(function ($image) {
            return str_contains($image['originUrl'], '/P/');
        })->map(function ($image) {
            return ['original_url' => $image['originUrl']];
        })->toArray();
    }

    private function batchInsert(array $data)
    {
        $newCarParts = [];
        $carPartImages = [];

        foreach ($data as $item) {
            $images = $item['carPartImages'];
            unset($item['carPartImages']);
            $newCarParts[] = $item;

            foreach ($images as $image) {
                $carPartImages[] = array_merge($image, ['new_car_part_id' => $item['id']]);
            }
        }

        // Perform bulk insert for car parts
        $this->bulkInsert('new_car_parts', $newCarParts);

        // Perform bulk insert for car part images
        $this->bulkInsert('new_car_part_images', $carPartImages);
    }


    private function bulkInsert($table, $data)
    {
        if (empty($data)) {
            return;
        }

        DB::table($table)->upsert($data, ['original_id'], array_keys(reset($data)));
    }

}
