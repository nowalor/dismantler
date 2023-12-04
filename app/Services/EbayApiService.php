<?php


namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class EbayApiService
{
    private Client $client;
    private string $apiUrl;

    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        $this->apiUrl = config('services.ebay.api_url');
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function getOAuthToken()
    {
        $authorizationHeader = base64_encode(
            config('services.ebay.app_id') . ':' . config('services.ebay.cert_id')
        );

        $scope = 'https://api.ebay.com/oauth/api_scope';

        $payload = [
          'grant_type' => 'client_credentials',
          'scope' => $scope,
        ];

        // Add a Basic Authorization header
        $response = $this->client->post($this->apiUrl . '/identity/v1/oauth2/token', [
            'form_params' => $payload,
            'headers' => [
                'Authorization' => 'Basic ' . $authorizationHeader,
            ],
        ]);

        $data = json_decode(
            $response->getBody()->getContents(),
            true, 512, JSON_THROW_ON_ERROR
        );

        return $data['access_token'];
    }
}
