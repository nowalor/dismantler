<?php

namespace App\Actions;

use Illuminate\Support\Facades\Storage;

class GetLocalizedPriceAction
{
    public function execute(
        string $locale,
        string $partFrom,
        int $price,
      /*  string $partType, */
    )
    {
        $pricesJson = Storage::get('prices.json');

        $prices = json_decode($pricesJson, true);

        $localizedPrices = $prices[$locale];


        $dismantleCountryPrices = $localizedPrices[$partFrom];

        $currency = $dismantleCountryPrices['currency'];
        $symbol = $dismantleCountryPrices['symbol'];
        $vat = $dismantleCountryPrices['vat'];

        $multiplier = $this->getMultiplier($price, $dismantleCountryPrices['ranges']);

        return [
            'currency' => $currency,
            'symbol' => $symbol,
            'vat' => $vat,
            'multiplier' => $multiplier,
        ];
    }

    private function getMultiplier(int $price, array $ranges)
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
}
