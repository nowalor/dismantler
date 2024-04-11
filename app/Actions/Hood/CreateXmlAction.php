<?php

namespace App\Actions\Hood;

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
        $xml = new \SimpleXMLElement(
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
            $item->addChild('quantity', '1');
            $item->addChild('condition', 'usedGood');

            $images = $item->addChild('images');
            foreach($part->carPartImages as $image) {
                $imageXml = $images->addChild('image');

                logger($image);
                $imageXml->addChild('imageURL' , $image->original_url);
            }
        }



        return $xml->asXML();
    }
}
