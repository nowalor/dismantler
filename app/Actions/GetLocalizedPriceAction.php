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

        if(!isset($prices[$locale])) {
            return $this->requiresRequest();
        }

        $localizedPrices = $prices[$locale];

        logger($locale);
        logger($localizedPrices);


        if(!isset($localizedPrices[$partFrom])) {
            return $this->requiresRequest();
        }

        $dismantleCountryPrices = $localizedPrices[$partFrom];

        if(isset($dismantleCountryPrices['requires_request']) && (bool)$dismantleCountryPrices['requires_request']) {
            return $this->requiresRequest();
        }

        $toCurrency = $dismantleCountryPrices['currency'];
        $symbol = $dismantleCountryPrices['symbol'];
        $vat = $dismantleCountryPrices['vat'];

        $multiplier = $this->getMultiplier($price, $dismantleCountryPrices['ranges']);
        $shipment = $this->getShipment($partType, $dismantleCompany, $dismantleCountryPrices['shipment']);

        $fromCurrency = $locale === 'da' ? 'dkk' : 'sek';


        return [
            'requires_request' => false,
            'currency' => [
                'from' => $fromCurrency,
                'to' => $toCurrency,
            ],
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

     public function requiresRequest(): array
     {
         return [
         'requires_request' => true,
         'currency' => [
             'from' => 9999999999,
             'to' => 9999999999,
         ],
         'symbol' => 9999999999,
         'vat' => 9999999999,
         'price' => 9999999999,
         'shipment' => 9999999999,
     ];
     }
}
