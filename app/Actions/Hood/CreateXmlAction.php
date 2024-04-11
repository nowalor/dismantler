<?php

namespace App\Actions\Hood;

use App\Models\NewCarPart;
use App\Services\PartInformationService;
use Illuminate\Database\Eloquent\Collection;
use SimpleXMLElement;

class CreateXmlAction
{
    private string $username;
    private string $apiPassword;
    private PartInformationService $partInformationService;


    public function __construct()
    {
        $this->username = config('services.hood.username');
        $this->apiPassword = config('services.hood.api_password');
        $this->partInformationService = new PartInformationService();
    }

    public function execute(
        string $functionType,
        $parts,
    )//: void
    {
        $path = base_path("public/exports/hello.xml");

        $xml = new SimpleXMLElement(
            "<?xml version='1.0' encoding='UTF-8'?>
            <api
                user='$this->username'
                type='public'
                version='2.0'
                password='$this->apiPassword'
            ></api>"
        );

        $xml->addChild('function', 'itemValidate');
        $xml->addChild('accountName', $this->username);
        $xml->addChild('accountPass', $this->apiPassword);

        $items = $xml->addChild('items');

        foreach($parts as $part) {
            $item = $items->addChild('item');

            $item->addChild('itemMode', 'classic');
            $item->addChild('categoryID', '2413');
            $item->addChild('itemName', $part->new_name);
            $item->addChild('quantity', '1');
            $item->addChild('condition', 'usedGood');
            $item->addChild('description', $this->resolveDescription($part));

            // Pay options
            $payOptions = $item->addChild('payOptions');
            $payOptions->addChild('option', 'wireTransfer');
            $payOptions->addChild('option', 'invoice');
            $payOptions->addChild('option', 'payPal');

            // Shipment methods
            $shipMethods = $item->addChild('shipMethods');

            $shipMethod = $shipMethods->addChild('shipMethod');
            $shipMethod->addAttribute('name', 'seeDesc_nat'); // TODO
            $shipMethod->addChild('value', 5);

            $item->addChild('startDate'); //TODO
            $item->addChild('startDate'); //TODO
            $item->addChild('durationInDays'); //TODO

            $item->addChild('priceStart', '3,50'); //TODO
            $item->addChild('price', '1205,95'); //TODO
            $item->addChild('salesTax', '19'); //TODO
            $item->addChild('warrantyShortenedFlag', '1'); //TODO
            $item->addChild('prodCatID', '1'); //TODO
            $item->addChild('ifIsSoldOut', 'hide'); //TODO
            $item->addChild('isApproved', '1'); //TODO


            $images = $item->addChild('images');
            foreach($part->carPartImages as $image) {
                $imageXml = $images->addChild('image');

                $imageXml->addChild('imageURL' , $image->original_url);
            }
        }



        return $xml->asXML($path);
    }

    // Make this reusable instead of copy paste from doc service
    private function resolveDescription(NewCarPart $carPart): string
    {

        $kba = $carPart->my_kba->map(function ($kbaNumber) {
            return [
                'hsn' => $kbaNumber->hsn,
                'tsn' => $kbaNumber->tsn,
            ];
        })->toArray();

        $kbaString = $this->kbaArrayToString($kba);

        $engineType = $carPart->engine_type ?? '';

        $description = "
            Einzelne auf den Fotos abgebildeten Anbauteile sind eventuel nicht mit im Lieferumfang enthalten. Mitglieferte Anbauteile sind von der Gewährleistung ausgeschlossen. \n
            Lagernummer: $carPart->article_nr \n
            Originale Ersatzteilnummer: $carPart->original_number \n
            Motor Kennung: $carPart->full_engine_code \n
            Motortype: $engineType \n
            Brandstofftype: $carPart->fuel \n
            Getriebe: {$this->partInformationService->getGearbox($carPart)} \n
            Laufleistung: $carPart->mileage_km(km) \n
            Fahrgestellnummer: $carPart->vin \n
            Baujahr: $carPart->model_year \n
            Kbas: $kbaString \n
        ";

        return $description;
    }

    private function kbaArrayToString(array $kbaArray): string
    {
        $propertiesArray = array_map(function ($kbaNumber) {
            return $kbaNumber['hsn'] . $kbaNumber['tsn'];
        }, $kbaArray);

        return implode(',', $propertiesArray);
    }
}
