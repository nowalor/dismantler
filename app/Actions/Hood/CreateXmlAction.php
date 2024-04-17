<?php

namespace App\Actions\Hood;

use App\Actions\GetTemplateInfoAction;
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
        $path = base_path("public/exports/hood.xml");

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

            $item->addChild('itemMode', 'shopProduct');
            $item->addChild('categoryID', '1006');
            $item->addChild('itemName', $part->name);
            $item->addChild('quantity', '1');
            $item->addChild('condition', 'usedGood');
            $item->addChild('description',
                htmlspecialchars($this->resolveDescription($part), ENT_QUOTES, "utf-8")
            );

//            // Pay options
//            $payOptions = $item->addChild('payOptions');
//            $payOptions->addChild('option', 'wireTransfer');
//            $payOptions->addChild('option', 'invoice');
//            $payOptions->addChild('option', 'payPal');

            // Shipment methods
            $shipMethods = $item->addChild('shipMethods');

            $shipMethod = $shipMethods->addChild('shipMethod');
            $shipMethod->addAttribute('name', 'seeDesc_nat'); // TODO
            $shipMethod->addChild('value', 0);

            $item->addChild('startDate'); //TODO
            $item->addChild('startDate'); //TODO
            $item->addChild('durationInDays'); //TODO

            $price = $part->getAutoteileMarktPriceAttribute() + $part->getShipmentAttribute();

            $item->addChild('priceStart', $price); //TODO
            $item->addChild('price', $price); //TODO
            $item->addChild('salesTax', '19'); //TODO
            $item->addChild('warrantyShortenedFlag', '1'); //TODO
            $item->addChild('prodCatID', '1'); //TODO
            $item->addChild('ifIsSoldOut', 'hide'); //TODO
            $item->addChild('isApproved', '1'); //TODO


            $images = $item->addChild('images');
            foreach($part->carPartImages as $image) {
                if(!$image->image_name_blank_logo) {
                    continue;
                }

                $url = "https://currus-connect.fra1.digitaloceanspaces.com/img/car-part/$part->id/logo-blank/{$image->image_name_blank_logo}";

                $imageXml = $images->addChild('image');

                $imageXml->addChild('imageURL' , $url);
            }
        }

        return $xml->saveXML($path);
    }

    // Make this reusable instead of copy paste from doc service
    private function resolveDescription(NewCarPart $part): string
    {
        $data = (new GetTemplateInfoAction())->execute($part);

        return view('hood', compact('part', 'data'))->toHtml();
    }

    private function kbaArrayToString(array $kbaArray): string
    {
        $propertiesArray = array_map(function ($kbaNumber) {
            return $kbaNumber['hsn'] . $kbaNumber['tsn'];
        }, $kbaArray);

        return implode(',', $propertiesArray);
    }
}
