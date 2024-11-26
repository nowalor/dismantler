<?php

namespace App\Actions;

use Exception;
use FreeCurrencyApi\FreeCurrencyApi\FreeCurrencyApiClient;
use GuzzleHttp\Client;

class ConvertCurrencyAction
{
    private array $exchangeRates = [];

    private FreeCurrencyApiClient $converter;

    public function __construct()
    {
        $this->converter = new FreeCurrencyApiClient(config('services.currency_converter.api_key'));
    }

    /**
     * Converts a given amount from one currency to another.
     *
     * @param float $amount The amount to convert.
     * @param string $fromCurrency The currency code to convert from.
     * @param string $toCurrency The currency code to convert to.
     * @return float The converted amount.
     * @throws Exception If conversion fails or currencies are invalid.
     */
    public function execute(float $amount, string $fromCurrency, string $toCurrency): float
    {
        if ($amount < 0) {
            throw new Exception('Amount must be a non-negative number.');
        }

        $fromCurrency = strtoupper($fromCurrency);
        $toCurrency = strtoupper($toCurrency);

        if ($fromCurrency === $toCurrency) {
            return $amount;
        }

        $exchangeRate = $this->getExchangeRate($fromCurrency, $toCurrency);

        return round($amount * $exchangeRate, 2); // Ensure a consistent format
    }

    /**
     * Retrieves the exchange rate between two currencies.
     *
     * @param string $fromCurrency The currency code to convert from.
     * @param string $toCurrency The currency code to convert to.
     * @return float The exchange rate.
     * @throws Exception If the exchange rate cannot be determined.
     */
    private function getExchangeRate(string $fromCurrency, string $toCurrency): float
    {
        if (empty($this->exchangeRates)) {
            $this->fetchExchangeRates($fromCurrency);
        }

        return $this->exchangeRates[$toCurrency];
    }

    /**
     * Fetches the latest exchange rates from the API and caches them.
     *
     * @return void
     * @throws Exception If the API request fails or returns invalid data.
     */
    private function fetchExchangeRates(string $from): void
    {
        logger($from);
        try {
            $response = $this->converter->latest([
                'base_currency' => $from,
                'currencies' => ['EUR', 'DKK', 'SEK'],
            ]);


            if (!isset($response['data']) || !is_array($response['data'])) {
                throw new Exception('Invalid API response structure.');
            }

            $this->exchangeRates = $response['data'];
        } catch (Exception $e) {
            throw new Exception("Failed to fetch exchange rates: " . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
