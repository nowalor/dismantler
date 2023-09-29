<?php

namespace App\Services;

use GuzzleHttp\Client;

class FenixApiService
{
    protected Client $httpClient;

    protected string $apiUrl;
    protected string $email;
    protected string $password;

    // API token
    protected string $token;
    protected string $tokenExpiresAt; //  "2023-06-19T08:53:12Z"

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

    public function getParts(array $options) //: array
    {
//        if ($this->tokenExpiresAt < now()->toIso8601String()) {
//            $this->authenticate();
//        }

//        $filters = [
//            "SbrPartCode" => ["7201", "7280", "7704", "7705", "7706", "7868", "7860", "7070", "7145"],
//            "CarBreaker" => ["N"],
//        ];
//
//        "Filters" => $filters,
//            "CreatedDate" => "2013-09-11T09:00",
//        "Skip" => 0,
//            "Page" => 1,
//            "Take" => 500,
//        "Action" => 1,


        $payload = [
            "IncludeNew" => false,
            "PartImages" => true,
            "IncludeSbrCarNames" => true,
            "MustHavePrice" => true,
            "CarBreaker" => "AT",
            "PartnerAccessLevel" => 2,
            "CreatedDate" => "2013-09-11T09:00",
            "SortBy" => [
                "Created" => "ASC"
            ],
            "Action" => 2,
            "Skip" => 0,
            "Page" => 1,
            "Take" => 500,
            "Filters" => [
                "SbrPartCode" => ["7201", "7280", "7704", "7705", "7706", "7868", "7860", "7070", "7145"],
                "CarBreaker" => ["N"],
            ],
        ];

        logger($options);
        $newPayload = $payload + $options;

        logger('lne');
        logger($newPayload);

//            $options = $this->getAuthHeaders();
//        $options['json'] = $payload;
//
//        $response = $this->httpClient->request("post", "$this->apiUrl/autoteile/parts", $options);
//
//        $response = json_decode($response->getBody()->getContents(), true);
//
//        return $response;
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
