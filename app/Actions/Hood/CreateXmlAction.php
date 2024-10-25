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

    public function __construct()
    {
        $this->username = config('services.hood.username');
        $this->apiPassword = config('services.hood.api_password');
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

        $xml->addChild('function', $functionType);
        $xml->addChild('accountName', $this->username);
        $xml->addChild('accountPass', $this->apiPassword);

        $items = $xml->addChild('items');

        foreach($parts as $part) {
            $item = $items->addChild('item');

            $item->addChild('itemMode', 'shopProduct');
            $item->addChild('categoryID', '1006');
            $item->addChild('itemName', $part->new_name);
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

            $shipMethod2 = $shipMethods->addChild('shipMethod');
            $shipMethod2->addAttribute('name', 'seeDesc_at'); // TODO
            $shipMethod2->addChild('value', 0);

            $item->addChild('startDate', now()->format('d.m.Y'));
            $item->addChild('startDate', now()->format('H:i'));
            $item->addChild('durationInDays', '30');
            $item->addChild('autoRenew', 'yes');

            $price = $this->price($part);

            $item->addChild('priceStart', $price);
            $item->addChild('price', $price);
            $item->addChild('salesTax', '19');
            $item->addChild('warrantyShortenedFlag', '1'); //TODO
            $item->addChild('prodCatID', '1'); //TODO
            $item->addChild('ifIsSoldOut', 'hide'); //TODO
            $item->addChild('isApproved', '1'); //TODO
            $item->addChild('itemNumber', $part->article_nr);
            $item->addChild('itemNumberUniqueFlag', 1);


            $images = $item->addChild('images');
            foreach($part->carPartImages as $image) {
                if(!$image->new_logo_german) {
                    continue;
                }

                $url = $image->logoGerman();

                $imageXml = $images->addChild('image');

                $imageXml->addChild('imageURL' , $url);
            }
        }

        return $xml->saveXML();
    }

    private function price(NewCarPart $part): int
    {
        if($part->country === 'DK') {
            return $part->translated_price + $part->shipment;
        }

        return $part->getAutoteileMarktPriceAttribute() + $part->getShipmentAttribute();
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
