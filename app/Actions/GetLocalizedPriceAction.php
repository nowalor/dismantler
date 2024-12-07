<?php

namespace App\Actions;

use Illuminate\Support\Facades\Storage;

class GetLocalizedPriceAction
{
    public function execute(
        string $locale,
        string $partFrom,
        int $price,
        string $partType,
        string $dismantleCompany,
    ): array
    {
        $pricesJson = Storage::get('prices.json');

        $prices = json_decode($pricesJson, true);

        $localizedPrices = $prices[$locale];


        $dismantleCountryPrices = $localizedPrices[$partFrom];

        $currency = $dismantleCountryPrices['currency'];
        $symbol = $dismantleCountryPrices['symbol'];
        $vat = $dismantleCountryPrices['vat'];

        $multiplier = $this->getMultiplier($price, $dismantleCountryPrices['ranges']);
        $shipment = $this->getShipment($partType, $dismantleCompany, $dismantleCountryPrices['shipment']);

        return [
            'currency' => $currency,
            'symbol' => $symbol,
            'vat' => $vat,
            'price' => $price * $multiplier,
            'shipment' => $shipment,
        ];
    }

    private function getMultiplier(int $price, array $ranges): float
    {
        foreach ($ranges as $range => $multiplier) {
            [$min, $max] = explode('-', $range);

            $max = ($max === 'X') ? PHP_INT_MAX : (int)$max;

            if ($price >= (int)$min && $price <= $max) {
                return $multiplier['multiplier'];
            }
        }

        return 1.5;
     }

     private function getShipment(
         string $partType,
         string $dismantleCompany,
         array $shipmentInformation
     ): array
     {
        $base = $shipmentInformation[$partType]['base'];
        $additional = 0;

        if(isset($shipmentInformation[$partType]['extra'][$dismantleCompany])) {
            $additional = $shipmentInformation[$partType]['extra'][$dismantleCompany];
        }
        return [
            'base' => $base,
            'additional' => $additional,
            'total' => $base + $additional,
        ];
     }
}
