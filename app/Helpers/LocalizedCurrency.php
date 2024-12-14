<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class LocalizedCurrency
{
    public function currency(): string
    {
        $locale = app()->getLocale();

        $pricesJson = Storage::get('prices.json');

        $prices = json_decode($pricesJson, true);

        $localizedPrices = $prices[$locale];

        $dismantleCountryPrices = $localizedPrices[$partFrom]; // TODO

        $toCurrency = $dismantleCountryPrices['currency'];


    }
}
