<?php

namespace App\Console\Commands\Base;

use App\Models\NewCarPart;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

abstract class FenixApiBaseCommand extends Command
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

        parent::__construct();
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

    protected function getParts(
        string $partTypeSbrCode,
    ): array
    {
        if ($this->tokenExpiresAt < now()->toIso8601String()) {
            $this->authenticate();
        }

        $filters = [
            'SbrPartCode' => [
                $partTypeSbrCode
            ],
        ];

        $parts = [];

        $payload = [
            "Take" => 40,
            "Skip" => 0,
            "Page" => 1,
            "IncludeNew" => false,
            "PartImages" => true,
            "CarImages" => false,
            "IncludeSbrPartNames" => false,
            "IncludeSbrCarNames" => true,
            "IncludeFitsSbrCarCodes" => false,
            "ReturnOnlyPartCodes" => false,
            "ReturnOnlyCarCodes" => false,
            "MustHavePrice" => false,
            "CarBreaker" => "AT",
            "PartnerAccessLevel" => 2,
            "Filters" => $filters,
            "SortBy" => [
                "Created" => "ASC"
            ],
            "Action" => 1
        ];

        $options = $this->getAuthHeaders();
        $options['json'] = $payload;

        $response = $this->httpClient->request("post", "$this->apiUrl/autoteile/parts", $options);
        $response = json_decode($response->getBody(), true);

        $parts[] = $response['Parts'];

        $response = [
            'parts' => $parts,
            'page' => $response['Page'],
            'count' => $response['Count'],
            'skip' => $response['Skip'],
        ];

        return $response;
    }

    protected function isPartSold(int $partId): bool
    {
        if ($this->tokenExpiresAt < now()->toIso8601String()) {
            $this->authenticate();
        }

        $payload = [
            "Take" => 40,
            "Skip" => 0,
            "Page" => 1,
            "IncludeNew" => false,
            "PartImages" => false,
            "CarImages" => false,
            "IncludeSbrPartNames" => false,
            "IncludeSbrCarNames" => false,
            "IncludeFitsSbrCarCodes" => false,
            "ReturnOnlyPartCodes" => false,
            "ReturnOnlyCarCodes" => false,
            "MustHavePrice" => false,
            "CarBreaker" => "AT",
            "PartnerAccessLevel" => 2,
            "Filters" => [
                "PartId" => [
                    "$partId",
                ],
            ],
            "SortBy" => [
                "Created" => "ASC"
            ],
            "Action" => 2
        ];

        $options = $this->getAuthHeaders();
        $options['json'] = $payload;

        $response = $this->httpClient->request("post", "$this->apiUrl/autoteile/parts", $options);
        $response = json_decode($response->getBody(), true);


        $count = $response['Count'];

        return $count === 0;
    }

    public function reservePart(NewCarPart $part): void
    {
        if(!isset($this->token)) {
            $this->authenticate();
        }

        if ($this->tokenExpiresAt < now()->toIso8601String()) {
            $this->authenticate();
        }

        $payload = [
            "Reservations" => [
                [
                    'Id' => 0,
                    //'PartId' => $part->part_id,
                    'PartId' => 78998657,
                    'Type' => 2,
                    'CarBreaker' => 'AT',
                    'ExternalReference' => $part->article_nr,
                    'ExternalSourceName' => 'autoteile',
                ],
            ]
        ];

        $options = $this->getAuthHeaders();
        $options['json'] = $payload;

        $tempUrl = 'https://test-fenixapi-integration.bosab.se/api';

        $response = $this->httpClient->request("post", "$tempUrl/autoteile/savereservations", $options);

        // Potential error cases
        // Status is not 200
        // Response is empty
        // Id we get back is 0
        $statusCode = $response->getStatusCode();

        $data = json_decode($response->getBody(), true);

        if($statusCode !== 200) {
            // TODO send slack notif
            logger($data);

        } elseif(empty($data)) {
            // TODO send slack notif
            logger($data);

        } elseif($data[0]['Id'] === 0) {
            // TODO send slack notif
            logger($data);
        }
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
