<?php

namespace App\Console\Commands;

use App\Models\CarPart;
use App\Models\CarPartImage;
use App\Models\DanishCarPartType;
use App\Models\DitoNumber;
use App\Models\NewCarPart;
use App\Models\NewCarPartImage;
use App\Scopes\CarPartScope;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
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

    /*
     *  [3575, 3744, 3746, 3749, 3616, 3617, 3812]
     */

    static private function transformSingle($item)
    {
        $newItem = [];

        $ditoNumber = DanishCarPartType::where('egluit_id', $item['itemTypeId'])
            ->first()?->code;

        if($item['companyId'] === '44') {
            $newItem['dismantle_company_name'] = 'AA';
        }

        if($item['companyId'] === '50') {
            $newItem['dismantle_company_name'] = 'BB';
        }

        if($item['companyId'] === '70') {
            $newItem['dismantle_company_name'] = 'CC';
        }

        $newItem['country'] = 'DK';
        $newItem['original_id'] = (int)$item['id'];
        $newItem['external_dismantle_company_id'] = $item['companyId'];
        $newItem['name'] = $item['name'];
//        $newItem['comments'] = $item['comments'];
//        $newItem['notes'] = $item['notes'];
        $newItem['quantity'] = $item['quantity'];
        $newItem['price_dkk'] = $item['price2']; // TODO
//        $newItem['price2'] = $item['price2'];
//        $newItem['price3'] = $item['price3'];
        $newItem['quality'] = $item['condition'];
        $newItem['article_nr_at_dismantler'] = $item['id'];
        $newItem['original_number'] = $item['oemNumber'];
//        $newItem['shelf_number'] = $item['shelfNumber'];
        $newItem['model_year'] = $item['year'];
        $newItem['data_provider_id'] = 3;
        $newItem['dito_number'] = $ditoNumber;
        $newItem['external_part_type_id'] = $item['itemTypeId'];
        $newItem['images'] = $item['images'];
//        $newItem['dismantle_company_id'] = 50; // TODO
//        $newItem['kilo_watt'] = $item['kiloWatt'];
//        $newItem['transmission_type'] = $item['transmissionType'];
//        $newItem['item_number'] = $item['itemNumber'];
//        $newItem['car_item_number'] = $item['carItemNumber'];
        $newItem['danish_item_code'] = $item['itemCode'];
        $newItem['vin'] = $item['carVinCode'];
        $newItem['engine_code'] = $item['engineCode'];
        $newItem['engine_type'] = $item['engineType'];
        $newItem['mileage_km'] = $item['kilometrage'];
//        $newItem['alternative_numbers'] = $item['alternativeNumbers'];
//        $newItem['color'] = $item['bodyColor'];
//        $newItem['car_first_registration_date'] = $item['carFirstRegistrationDate'];

        return $newItem;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('max_execution_time', 50000000);
        ini_set('max_input_time', 50000000);

        $dismantleCompanyIds = [
            '44',
            '50',
//            '70'
        ];

        foreach ($dismantleCompanyIds as $companyId) {
            try {
                for ($i = 0; $i < 199999; $i++) {
                    $response = $this->fetchPage($i, $companyId);

//                    logger("seeding page $i");

                    if (empty($response)) {
                        Log::info("Broke on page $i");
                        break;
                    }
//                    $collectedResponse = collect($response);
//                    $filteredResponse = $collectedResponse->whereIn('itemTypeId', CarPart::CAR_PART_TYPE_IDS_TO_INCLUDE)->all();



                    $transformedData = $this->transformData($response);
                    if(!empty($transformedData)) {
//                        Log::info('------------------- TRANSFORMED DATA2 -------------------');
//                        Log::info(json_encode($transformedData));
                    }
//                    NewCarPart::insert($transformedData);

                    foreach($transformedData as $item) {
//                        logger('--- item ---');
//                        logger($item);
                        $newCarPart = NewCarPart::firstOrCreate(['original_id' => $item['original_id']], $item);

                        $this->transformImages($newCarPart, $item['images']);
                    }
//                    CarPart::insert($transformedData);

//                    $transformedImages = $this->transformImages(collect($response)->toArray());

//                    NewCarPartImage::insert($transformedImages);

                }
                return 'loops finished';

            } catch (Exception $ex) {
                logger('failed..');
                Log::info($ex->getMessage());

                return 'in catch';
            }
        }

        return 'finished';
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

    private function transformImages(NewCarPart $carPart, array $images)
    {
        $filteredImages = collect($images)->filter(function ($image) {
            return str_contains($image['originUrl'], '/P/');
        });

            foreach ($filteredImages as $image) {
                $carPart->carPartImages()->create([
                    'original_url' => $image['originUrl'],
                ]);
            }
    }
}
