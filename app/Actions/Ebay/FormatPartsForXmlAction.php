<?php

namespace App\Actions\Ebay;

use App\Models\NewCarPart;

class FormatPartsForXmlAction
{
    public function execute($parts): array
    {
        $products = [];

        foreach ($parts as $part) {
            $products[] = $this->formatPart($part);
        }

        return $products;
    }

    private function formatPart(NewCarPart $part): array
    {
        $combatibility = $this->getCombatability($part);

        return [
            'product' => [
                'SKU' => $part->article_nr,
                'productInformation' => [
                    'localizedFor' => 'de_DE',
                    'title' => $part->name,
                    'description' => [
                        'productDescription' => $this->getDescription($part),
                    ],
                    'attribute' => $this->attributes($part),
                    'EAN' => $part->article_nr, // TODO
                    'compatibility' => $combatibility,
                    'pictureURL' => $this->getPictureUrls($part),
                    'conditionInfo' => [
                        'condition' => 'Used', // TODO
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
                        'category' => '33615', // Engines
                        // Add other distribution details
                        'pricingDetails' => [
                            'listPrice' => $part->getNewPriceAttribute(),
                            'strikeThroughPrice' => $part->getNewPriceAttribute(),
//                            'minimumAdvertisedPrice' => '18.18465',
//                            'minimumAdvertisedPriceHandling' => '',
                        ],
//                        'templateName' => 'plantilla_ebay.html',
                        'customFields' => $this->getCustomFields($part),
                    ],
                ],
                'inventory' => [
                    'totalShipToHomeQuantity' => '0',
                ],
            ],
        ];
    }

    private function getCombatability(NewCarPart $part): array
    {
        $kTypes = $part
            ->germanDismantlers()
            ->with("kTypes")
            ->get()
            ->pluck("kTypes")
            ->flatten()
            ->unique("id")
            ->pluck("k_type");

        return array_map(static function ($kType) {
            return ["name" => "KType", "value" => $kType];
        }, $kTypes->toArray());
    }

    private function getCustomFields(NewCarPart $part): array
    {
        $fields = [];

        $part->carPartImages->each(function ($image, $index) {
            $fields[]['customField'] = ["Image$index" => $image->image_name_blank_logo];
        });

        $fuel = $part->fuel;

        if($fuel === 'Bensin') {
            $fuel = 'Benzin';
        }

        $fields['customField'][] = ['name' => 'Lagernummer', 'value' => $part->article_nr];
        $fields['customField'][] = ['name' => 'Kba', 'value' => $this->getKba($part)];
        $fields['customField'][] = ['name' => 'Originale Ersatzteilnummer', 'value' => $part->original_number];
        $fields['customField'][] = ['name' => 'Motor Kennung', 'value' => $part->engine_code];
        $fields['customField'][] = ['name' => 'Motortype', 'value' => $part->engine_type ?? ''];
        $fields['customField'][] = ['name' => 'Brandstofftype', 'value' => $fuel];
        $fields['customField'][] = ['name' => 'Laufleistung(KM)', 'value' => $part->milega_km];
        $fields['customField'][] = ['name' => 'Model Jahr', 'value' => $part->model_year];
        $fields['customField'][] = ['name' => 'Getriebe', 'value' => $part->gearbox_nr];
        $fields['customField'][] = ['name' => 'Fahrgestellnummer', 'value' => $part->vin];

        return $fields;
    }

    private function getPictureUrls(NewCarPart $part): array
    {
        return array_column(
            $part->carPartImages->toArray() ?? [],
            'image_name_blank_logo'
        );
    }

    private function getDescription(NewCarPart $part): string
    {
        return 'description TODO';
    }

    private function getKba(NewCarPart $part): string
    {
        $kba = $part->my_kba->map(function ($kbaNumber) {
            return [
                'hsn' => $kbaNumber->hsn,
                'tsn' => $kbaNumber->tsn,
            ];
        })->toArray();

        $propertiesArray = array_map(function ($kbaNumber) {
            return $kbaNumber['hsn'] . $kbaNumber['tsn'];
        }, $kba);

        return implode(',', $propertiesArray);
    }

    private function attributes(NewCarPart $part): array
    {
        return [
          ['name' => 'Hersteller', 'value' => 'todo'], // Manufacturer
          ['name' => 'Anzahl der Zylinder', 'value' => 'todo'], // Number of cylinders
          ['name' => 'Kraftstoffart', 'value' => 'todo'], // Fuel type
          ['name' => 'Hubraum', 'value' => 'todo'], // Number of Displacement
//          ['name' => 'Produktart', 'value' => 'todo'], // Product Type
          ['name' => 'Herstellernummer', 'value' => 'todo'], //  Manufacturer number
          ['name' => 'OE/OEM Referenznummer(n)', 'value' => $part->original_number], //  OEM
        ];

//        return [
//            ['name' => 'Lagernummer', 'value' => $part->article_nr],
//            ['name' => 'Kba', 'value' => $this->getKba($part)],
//            ['name' => 'Originale Ersatzteilnummer', 'value' => $part->original_number],
//            ['name' => 'Motor Kennung', 'value' => $part->engine_code],
//            ['name' => 'Motortype', 'value' => $part->engine_type ?? ''],
//            ['name' => 'Brandstofftype', 'value' => $part->fuel],
//            ['name' => 'Laufleistung(KM)', 'value' => $part->milega_km],
//            ['name' => 'Model Jahr', 'value' => $part->model_year],
//            ['name' => 'Getriebe', 'value' => $part->gearbox_nr],
//            ['name' => 'Fahrgestellnummer', 'value' => $part->vin],
//        ];
    }
}
