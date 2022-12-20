<?php

namespace App\Console\Commands;

use App\Models\CarPart;
use App\Models\CarPartImage;
use App\Scopes\CarPartScope;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SeedGermanCarPartsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'german:parts:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed parts from German dismantlers on a schedule';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('max_execution_time', 50000000);
        ini_set('max_input_time', 50000000);

        $dismantleCompanyIds = ['44', '50' , '70'];

        foreach($dismantleCompanyIds as $companyId) {
            try {
                for ($i = 0; $i < 199999; $i++) {
                    $response = $this->fetchPage($i, $companyId);

                    if (empty($response)) {
                        Log::info("Broke on page $i");
                        $this->info('About to break on page ' . $i);
                        break;
                    }

                    $transformedData = $this->transformData($response);

                    foreach($transformedData as $item) {
                        $itemId = $item['id'];
                        unset($item['id']);
                        CarPart::withoutGlobalScope(new CarPartScope())->updateOrCreate(['id' => $itemId], $item);
                    }

                    $transformedImages = $this->transformImages($response);

                    foreach($transformedImages as $image) {
                        CarPartImage::firstOrCreate($image);
                    }

                }

                $this->info('Loop done');
            } catch (Exception $ex) {
                Log::info('------- ERROR ---------');
                Log::info($ex->getMessage());

                $this->info('In catch');

            }
        }
    }


    static private function transformSingle($item)
    {
        $newItem = [];

        $newItem['id'] = intval($item['id']);
        $newItem['name'] = $item['name'];
        $newItem['comments'] = $item['comments'];
        $newItem['notes'] = $item['notes'];
        $newItem['quantity'] = $item['quantity'];
        $newItem['price1'] = $item['price1'];
        $newItem['price2'] = $item['price2'];
        $newItem['price3'] = $item['price3'];
        $newItem['condition'] = $item['condition'];
        $newItem['oem_number'] = $item['oemNumber'];
        $newItem['shelf_number'] = $item['shelfNumber'];
        $newItem['year'] = $item['year'];
        $newItem['car_part_type_id'] = (int)$item['itemTypeId'];
        $newItem['dismantle_company_id'] = $item['companyId'];
        $newItem['kilo_watt'] = $item['kiloWatt'];
        $newItem['transmission_type'] = $item['transmissionType'];
        $newItem['item_number'] = $item['itemNumber'];
        $newItem['car_item_number'] = $item['carItemNumber'];
        $newItem['item_code'] = $item['itemCode'];
        $newItem['car_vin_code'] = $item['carVinCode'];
        $newItem['engine_code'] = $item['engineCode'];
        $newItem['engine_type'] = $item['engineType'];
        $newItem['kilo_range'] = $item['kilometrage'];
        $newItem['alternative_numbers'] = $item['alternativeNumbers'];
        $newItem['color'] = $item['bodyColor'];
        $newItem['car_first_registration_date'] = $item['carFirstRegistrationDate'];

        return $newItem;
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

    private function transformData(array $data)
    {
        $carParts = array_map('self::transformSingle', $data);
        $imageArr = [];

        // $test = array_map('self::transformImages', $data);
        // $images = array_push($imageArr, array_map('self::transformImages', $data));

        return $carParts;
    }

    private function transformImages(array $data)
    {
        $newArr = [];

        foreach($data as $item) {
            foreach($item['images'] as $image) {
                array_push($newArr, [
                    'car_part_id' => $item['id'],
                    'origin_url' => $image['originUrl'],
                    'thumbnail_url' => $image['thumbnail120Url'],
                ]);
            }
        }

        return $newArr;
    }

}
