<?php

namespace App\Actions\FenixAPI;

use GuzzleHttp\Client;

class FenixApiAction
{
    protected string $apiUrl;
    protected string $email;
    protected string $password;

    public function __construct()
    {
        $this->apiUrl = config('services.fenix_api.base_uri');
        $this->email = config('services.fenix_api.email');
        $this->password = config('services.fenix_api.password');

        $this->httpClient = new Client([
            'verify' => false,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    protected function authenticate(): void
    {
        $payload = [
            'username' => $this->email,
            'password' => $this->password,
        ];

        $response = $this->httpClient->post($this->apiUrl . '/account', [
            'body' => json_encode($payload),
        ]);

        $responseBody = json_decode($response->getBody()->getContents(), true);

        $this->token = $responseBody['Token'];
        $this->tokenExpiresAt = $responseBody['Expiration'];
    }

    protected function getAuthHeaders(): array
    {
        return [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ],
        ];
    }
}
