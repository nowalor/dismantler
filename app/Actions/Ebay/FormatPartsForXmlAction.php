<?php

namespace App\Actions\Ebay;

use App\Models\NewCarPart;
use App\Services\PartInformationService;

class FormatPartsForXmlAction
{
    private PartInformationService $partInformationService;

    const CATEGORY_MAPPER = [
        1 => '33615',
        2 => '262256',
        3 =>  '171115',
        4 => '171117',
        5 => '174028',
        6 => '33629',
        7 => '262244',
        8 => '33596',
        9 => '262085',
        10 => '33675',
        11 => '33596',
        12 => '33588',
        13 => '185017',
        14 => '33596',
        15 => '33596',
        16 => '174119',
        17 => '169395',
        18 => '9887',
        19 => '9887',
        20 => '177697',
    ];

    public function __construct()
    {
        $this->partInformationService = new PartInformationService();
    }

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
                    'title' => $part->new_name,
                    'description' => [
                        'productDescription' => $this->resolveDescription($part),
                    ],
                    'attribute' => $this->attributes($part),
                    'EAN' => 'Nicht zutreffend',
                    'compatibility' => $combatibility,
                    'pictureURL' => $this->getPictureUrls($part),
                    'conditionInfo' => [
                        'condition' => 'USED_EXCELLENT',
                    ],
//                    'shippingDetails' => [
//                        'measurementSystem' => '',
//                        'weightMajor' => '',
//                        'weightMinor' => '',
//                        'length' => '',
//                        'width' => '',
//                        'height' => '',
//                        'packageType' => '',
//                    ],
                ],
                'distribution' => [
                    'localizedFor' => 'de_DE',
                    'channelDetails' => [
                        'VATPercent' => 19,
                        'templateName' => 'default.html',
                        'channelID' => 'EBAY_DE',
//                        'category' => '33615', // Engines
//                        'category' => '171115', // Automatic gearbox
                        'category' => self::CATEGORY_MAPPER[$part->car_part_type_id],
                        'paymentPolicyName' => 'eBay Managed Payments (341130335023)',
                        'returnPolicyName' => '30 Tage Rückgabe. Käufer zahlt Rückversand',
                        'shippingPolicyName' => 'Kostenloser Versand',
                        // Add other distribution details
                        'pricingDetails' => [
                            'listPrice' => $part->ebayPrice('de'),
                            'strikeThroughPrice' => $part->ebayPrice('de'),
//                            'minimumAdvertisedPrice' => '18.18465',
//                            'minimumAdvertisedPriceHandling' => '',
                        ],
//                        'templateName' => 'plantilla_ebay.html',
                        'customFields' => $this->getCustomFields($part),
                    ],
                ],
                'regulatory' => [
                    'manufacturer' => [
                        'companyName' => $part->sbrCode->producer,
                        'addressLine1' => $part->sbrCode->producer_address,
                        'phone' => $part->sbrCode->producer_phone,
                        'email' => $part->sbrCode->producer_email,
                    ]
                ],

                'inventory' => [
                    'totalShipToHomeQuantity' => '1',
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

        $images = $part->carPartImages->toArray();

        $url = isset($images[0]) ?
            "https://currus-connect.fra1.digitaloceanspaces.com/img/car-part/$part->id/logo-blank/{$images[0]['image_name_blank_logo']}" :
            'https://via.placeholder.com/500/eeeeee/999?text=Grafik-4';

        $imageOneSet = isset($images[0]) ? '' : 'none';


        $fields['customField'][] = ['name' => 'Image1', 'value' => $url];
        $fields['customField'][] = ['name' => 'Image1class', 'value' => $imageOneSet];

        for($i = 2; $i < 7; $i++) {
            $url =  isset($images[$i - 1]) ?
                "https://currus-connect.fra1.digitaloceanspaces.com/img/car-part/$part->id/logo-blank/{$images[$i - 1]['image_name_blank_logo']}"
                : 'image-missing';
            $isSet = isset($images[$i - 1]) ? '' : 'none';

            $fields['customField'][] = ['name' => "Image$i", 'value' => $url];
            $fields['customField'][] = ['name' => "Image{$i}class", 'value' => $isSet];
        }

        $fuel = $part->fuel;

        if ($fuel === 'Bensin') {
            $fuel = 'Benzin';
        }

        $fields['customField'][] = ['name' => 'Lagernummer', 'value' => $part->article_nr];
        $fields['customField'][] = ['name' => 'Kba', 'value' => $this->getKba($part)];
        $fields['customField'][] = ['name' => 'OriginaleErsatzteilnummer', 'value' => $part->original_number];
        $fields['customField'][] = ['name' => 'MotorKennung', 'value' => $part->engine_code];
        $fields['customField'][] = ['name' => 'Motortype', 'value' => $part->engine_type ?? ''];
        $fields['customField'][] = ['name' => 'Brandstofftype', 'value' => $fuel];
        $fields['customField'][] = ['name' => 'LaufleistungKM', 'value' => $part->mileage_km];
        $fields['customField'][] = ['name' => 'ModelJahr', 'value' => $part->model_year];
        $fields['customField'][] = ['name' => 'Getriebe', 'value' => $part->gearbox_nr];
        $fields['customField'][] = ['name' => 'Fahrgestellnummer', 'value' => $part->vin];
        $fields['customField'][] = ['name' => 'name', 'value' => $part->description_name];

        // New
        $fields['customField'][] = ['name' => 'Hersteller', 'value' => $this->getProducer($part)];
        $fields['customField'][] = ['name' => 'Modell', 'value' => $this->getBrand($part)];

        return $fields;
    }

    private function getProducer(NewCarPart $carPart): string
    {
        $dito = $carPart->sbrCode?->ditoNumbers()->first();

        if(!$dito) {
            return $carPart->sbr_car_name;
        }

        return $dito->producer;
    }

    private function getBrand(NewCarPart $carPart): string
    {
        $dito = $carPart->sbrCode?->ditoNumbers()->first();

        if(!$dito) {
            return $carPart->sbr_car_name;
        }

        return $dito->brand;
    }

    private function getPictureUrls(NewCarPart $part): array
    {
        return array_map(static function ($img) use ($part) {
            return "https://currus-connect.fra1.digitaloceanspaces.com/img/car-part/$part->id/logo-blank/{$img['image_name_blank_logo']}";
        }, $part->carPartImages->toArray());
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
        $fuel = $part->fuel;

        if ($fuel === 'Bensin') {
            $fuel = 'Benzin';
        }

        // "germanDismantlers" && "kTypes" should be through eager loading and NOT relationship
        // Reason is because they need a follow up query to prevent bugs
        // That would be to have to do here
        $brand = $part->germanDismantlers
            ->first()
            ?->kTypes
            ->first()
            ?->brand;

        if (!$brand) {
            die('This car has no brand');
        }

        return [
            ['name' => 'Hersteller', 'value' => $brand], // Manufacturer
            ['name' => 'Kraftstoffart', 'value' => $fuel], // Fuel type
            ['name' => 'OE/OEM Referenznummer(n)', 'value' => $part->original_number], //  OEM
            ['name' => 'Kba', 'value' => $this->getKba($part)],
            ['name' => 'MotorKennung', 'value' => $part->engine_code],
            ['name' => 'Motortype', 'value' => $part->engine_type ?? ''],
            ['name' => 'LaufleistungKM', 'value' => $part->mileage_km],
            ['name' => 'ModelJahr', 'value' => $part->model_year],
            ['name' => 'Getriebe', 'value' => $part->gearbox_nr],
            ['name' => 'Fahrgestellnummer', 'value' => $part->vin],
            ['name' => 'name', 'value' => $part->description_name],

        ];
    }

    /*
     * TODO: refactor this function to be reusable between this & AutoteileMartkDocService
     */
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

        return "
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
    }

    /*
    * TODO: refactor this function to be reusable between this & AutoteileMartkDocService
    */
    private function kbaArrayToString(array $kbaArray): string
    {
        $propertiesArray = array_map(function ($kbaNumber) {
            return $kbaNumber['hsn'] . $kbaNumber['tsn'];
        }, $kbaArray);

        return implode(',', $propertiesArray);
    }
}
