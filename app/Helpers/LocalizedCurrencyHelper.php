<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class LocalizedCurrencyHelper
{
    public function currency(): string
    {
        /*
         * TODO, use an enum or class const or smth..
         */
        $currencyMapper = [
            'de' => 'eur',
            'da'  => 'dkk',
            'sv' => 'sek',
            'pl' => 'eur',
            'fr' => 'eur',
            'it' => 'eur'
        ];

        $locale = app()->getLocale();

        if(!isset($currencyMapper[$locale])) {
            abort(422,'Something went wrong mapping localization to currency');
        }

        return $currencyMapper[$locale];
    }
}
