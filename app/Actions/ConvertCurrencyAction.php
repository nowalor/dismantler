<?php

namespace App\Actions;

use Exception;
use GuzzleHttp\Client;

class ConvertCurrencyAction
{
    private Client $httpClient;
    private array $exchangeRates = [];

    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => config('services.currency_converter.api_url'),
        ]);
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
            return $amount; // No conversion needed
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
        try {
            $response = $this->httpClient->get('latest', [
                'query' => [
                    'base' => $from,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if (!isset($data['rates']) || !is_array($data['rates'])) {
                throw new Exception('Invalid API response structure.');
            }

            $this->exchangeRates = $data['rates'];
        } catch (Exception $e) {
            throw new Exception("Failed to fetch exchange rates: " . $e->getMessage(), $e->getCode(), $e);
        }
    }
}
