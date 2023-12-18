<?php

namespace App\Actions\Ebay;

use App\Models\NewCarPart;
use Illuminate\Database\Eloquent\Collection;

class FormatPartsForCsvAction
{
    public function execute($parts): array
    {
        $products = [];

        foreach($parts as $part) {
            $products = $this->formatPart($part);
        }

        return $products;
    }

    private function formatPart(NewCarPart $part)
    {
        return [
            'product' => [
                'SKU' => $part->article_nr,
                'productInformation' => [
                    'localizedFor' => 'de_DE',
                    'title' => $part->name,
                    'description' => [
                        'productDescription' => 'prueba',
                    ],
                    'attribute' => [
                        ['name' => 'Binding', 'value' => 'Xiaomi'],
                        ['name' => 'Language', 'value' => ''],
                    ],
                    'EAN' => '6934177715433',
                    'pictureURL' => $this->getPictureUrls(),
                    'conditionInfo' => [
                        'condition' => 'New',
                    ],
                    'shippingDetails' => [
                        'measurementSystem' => '',
                        'weightMajor' => '',
                        'weightMinor' => '',
                        'length' => '',
                        'width' => '',
                        'height' => '',
                        'packageType' => '',
                    ],
                ],
                'distribution' => [
                    'localizedFor' => 'de_DE',
                    'channelDetails' => [
                        'channelID' => 'EBAY_DE',
                        'category' => '20706',
                        // Add other distribution details
                        'pricingDetails' => [
                            'listPrice' => '36.3693',
                            'strikeThroughPrice' => '39.5793',
                            'minimumAdvertisedPrice' => '18.18465',
                            'minimumAdvertisedPriceHandling' => '',
                        ],
                        'templateName' => 'plantilla_ebay.html',
                        'customFields' => [
                            'customField' => [
                                ['name' => 'Image1', 'value' => 'https://miberia.com/5477/xiaomi-mi-led-smart-bulb-bombilla-inteligente-pack-2.jpg'],
                                ['name' => '', 'value' => ''],
                            ],
                        ],
                    ],
                ],
                'inventory' => [
                    'totalShipToHomeQuantity' => '0',
                ],
            ],
        ];
    }

    private function getPictureUrls(NewCarPart $part): array
    {
        return array_column(
            $part->carPartImages()?->toArray() ?? [], 
            'image_name_blank_logo'
        );
    }
}
