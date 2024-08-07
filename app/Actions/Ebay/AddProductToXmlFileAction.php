<?php

namespace App\Actions\Ebay;

use App\Models\NewCarPart;

class AddProductToXmlFileAction
{
    public function execute(array $data): string
    {
        $xmlName = 'ebay-import-' . now() . '.xml';

        $path = base_path("public/exports/$xmlName");

        $xml = new \SimpleXMLElement(
            '<?xml version="1.0" encoding="UTF-8"?><productRequest></productRequest>'
        );

        foreach ($data as $key => $value) {
            $product = $xml->addChild('product');

            // Add product information
            $productInformation = $product->addChild('productInformation');
            $productInformation->addAttribute('localizedFor', $value['product']['productInformation']['localizedFor']);

            $product->addChild('SKU', $value['product']['SKU']);
            $productInformation->addChild('title', $value['product']['productInformation']['title']);
            $productInformation->addChild('subtitle');

            $description = $productInformation->addChild('description');
            $description->addChild('productDescription', '<![CDATA[' . $value['product']['productInformation']['description']['productDescription'] . ']]>');


            foreach($value['product']['productInformation']['compatibility'] as $compatibility) {
                $compatibilityEl =  $productInformation->addChild('compatibility');

                $compatibilityEl->addChild('value', $compatibility['value'])->addAttribute('name', $compatibility['name']);
            }

            foreach ($value['product']['productInformation']['attribute'] as $attribute) {
                $productInformation->addChild('attribute', $attribute['value'])->addAttribute('name', $attribute['name']);
            }

            $productInformation->addChild('EAN', $value['product']['productInformation']['EAN']);

            foreach ($value['product']['productInformation']['pictureURL'] as $pictureURL) {
                $productInformation->addChild('pictureURL', $pictureURL);
            }

            $conditionInfo = $productInformation->addChild('conditionInfo');
            $conditionInfo->addChild('condition', $value['product']['productInformation']['conditionInfo']['condition']);

//            $shippingDetails = $productInformation->addChild('shippingDetails');
//            $shippingDetails->addAttribute('measurementSystem', $value['product']['productInformation']['shippingDetails']['measurementSystem']);
//            $shippingDetails->addChild('weightMajor', $value['product']['productInformation']['shippingDetails']['weightMajor']);
//            $shippingDetails->addChild('weightMinor', $value['product']['productInformation']['shippingDetails']['weightMinor']);
//            $shippingDetails->addChild('length', $value['product']['productInformation']['shippingDetails']['length']);
//            $shippingDetails->addChild('width', $value['product']['productInformation']['shippingDetails']['width']);
//            $shippingDetails->addChild('height', $value['product']['productInformation']['shippingDetails']['height']);
//            $shippingDetails->addChild('packageType', $value['product']['productInformation']['shippingDetails']['packageType']);

            // Add distribution information
            $distribution = $product->addChild('distribution');
            $distribution->addAttribute('localizedFor', $value['product']['distribution']['localizedFor']);

            $channelDetails = $distribution->addChild('channelDetails');
            $channelDetails->addChild('VATPercent', $value['product']['distribution']['channelDetails']['VATPercent']);
            $channelDetails->addChild('templateName', $value['product']['distribution']['channelDetails']['templateName']);
            $channelDetails->addChild('channelID', $value['product']['distribution']['channelDetails']['channelID']);
            $channelDetails->addChild('category', $value['product']['distribution']['channelDetails']['category']);

            $channelDetails->addChild('paymentPolicyName', $value['product']['distribution']['channelDetails']['paymentPolicyName']);
            $channelDetails->addChild('returnPolicyName', $value['product']['distribution']['channelDetails']['returnPolicyName']);
            $channelDetails->addChild('shippingPolicyName', $value['product']['distribution']['channelDetails']['shippingPolicyName']);

            $pricingDetails = $channelDetails->addChild('pricingDetails');
            $pricingDetails->addChild('listPrice', $value['product']['distribution']['channelDetails']['pricingDetails']['listPrice']);
            $pricingDetails->addChild('strikeThroughPrice', $value['product']['distribution']['channelDetails']['pricingDetails']['strikeThroughPrice']);
//            $pricingDetails->addChild('minimumAdvertisedPrice', $value['product']['distribution']['channelDetails']['pricingDetails']['minimumAdvertisedPrice']);
//            $pricingDetails->addChild('minimumAdvertisedPriceHandling', $value['product']['distribution']['channelDetails']['pricingDetails']['minimumAdvertisedPriceHandling']);

    //            $channelDetails->addChild('templateName', $value['product']['distribution']['channelDetails']['templateName']);

            $customFields = $channelDetails->addChild('customFields');
            foreach ($value['product']['distribution']['channelDetails']['customFields']['customField'] as $customField) {
                $field = $customFields->addChild('customField');
                $field->addChild('name', $customField['name']);
                $field->addChild('value', $customField['value']);
            }

            // Add inventory information
            $inventory = $product->addChild('inventory');
            $inventory->addChild('totalShipToHomeQuantity', $value['product']['inventory']['totalShipToHomeQuantity']);

            $this->markAsLive($value);
        }

        // Format the XML for better readability
        $dom = dom_import_simplexml($xml)->ownerDocument;
        $dom->formatOutput = true;

        // Save the XML to a file
        $xml->asXML($path);

        return $xmlName;
    }

    private function markAsLive(array $value): void
    {
        $sku = $value['product']['SKU'];

        NewCarPart::where('article_nr', $sku)->update(['is_live_on_ebay' => 1]);
    }
}
