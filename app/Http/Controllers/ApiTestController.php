<?php

namespace App\Http\Controllers;

use App\Models\CarPart;
use App\Models\CarPartImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiTestController extends Controller
{
    static private function transformSingle($item)
    {
        $newItem = [];

        $newItem['id'] = (int)$item['id'];
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
        $newItem['dismantle_company_id'] = 50;
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

    public function __invoke()
    {
        ini_set('max_execution_time', 50000000);
        ini_set('max_input_time', 50000000);
        DB::beginTransaction();
        try {
            for ($i = 0; $i < 199999; $i++) {
                $response = $this->fetchPage($i);

                if (empty($response)) {
                    Log::info("Broke on page $i");
                    break;
                }

                $transformedData = $this->transformData($response);

                foreach($transformedData as $item) {
                    CarPart::firstOrCreate($item);
                }

                $transformedImages = $this->transformImages($response);

                foreach($transformedImages as $image) {
                    CarPartImage::firstOrCreate($image);
                }

            }

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            return $ex;
        }
    }

    private function fetchPage(int $page)
    {
        $apiKey = config()->get('app.egluit_api_key');
        $url = 'https://v2-cloud.egluit.dk/gql/graphql';

        $variables = [
            'input' => [
                'companyId' => '50',
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
