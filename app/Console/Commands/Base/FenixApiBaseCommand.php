<?php

namespace App\Console\Commands\Base;

use App\Services\SlackNotificationService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use JsonException;

abstract class FenixApiBaseCommand extends Command
{
    protected Client $httpClient;

    protected string $apiUrl;
    protected string $email;
    protected string $password;

    // API token
    protected string $token;
    protected string $tokenExpiresAt; //  "2023-06-19T08:53:12Z"

    private SlackNotificationService $notificationService;

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

        $this->notificationService = new SlackNotificationService();

        parent::__construct();
    }

    protected function authenticate(): void
    {
        $payload = [
            'username' => $this->email,
            'password' => $this->password,
        ];

        // Currently live URL is hard coded
        // Authenticate with test URL was not working for some reason...
        $response = $this->httpClient->post('https://fenixapi-integration.bosab.se/api' . '/account', [
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

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    protected function getParts($carBreaker): array
    {
        if ($this->tokenExpiresAt < now()->toIso8601String()) {
            $this->authenticate();
        }

        $filters = [
            "SbrPartCode" => [
 /*               "7201",
                "7280",
                "7704",
                "7705",
                "7706",
                "7868",
                "7860",
                "7070",
                "7145",
                "7143",
                "7302",*/
                // New ones
       /*         "4626", // screens
                "7470",
                "7487",
                "7816",
                "3230",
                "7255",
                "7295",
                "7393",
                "7411",
                "7700",
                "7835",*/
                "3135",
                "1020",
                "1021",
                "1022",
                "4638",
                "3235",
                "3245",
                "4573",
                "7050",
                "7051",
                "7052",
                "7070",
            ],
          //  "SbrPartCode" => ["7475", "7645", "3220", "7468", "7082"], // New part types

            "CarBreaker" => [$carBreaker], ];

        $parts = [];

        $count = $this->getCount();
        $increment = 500;
        $page = 1;

        // Keep incrementing take by 500 until we have no parts left
        for ($skip = 0; $skip < $count + $increment; $skip += $increment) {
            $payload = [
                "Take" => 500,
                "Skip" => $skip,
                "Page" => $page,
                "IncludeNew" => false,
                "PartImages" => true,
                "IncludeSbrCarNames" => true,
                "MustHavePrice" => true,
                "CarBreaker" => "AT",
                "PartnerAccessLevel" => 2,
                "Filters" => $filters,
                "CreatedDate" => "2013-09-11T09:00",
                "SortBy" => [
                    "Created" => "ASC"
                ],
                "Action" => 1
            ];

            $options = $this->getAuthHeaders();
            $options['json'] = $payload;

            $response = $this->httpClient->request("post", "$this->apiUrl/autoteile/parts", $options);

            $response = json_decode($response->getBody()->getContents(), true);

            $parts = array_merge($parts, $response['Parts']);

            ++$page;
        }

        $response = [
            'parts' => $parts,
            'page' => $response['Page'],
            'count' => $response['Count'],
            'skip' => $response['Skip'],
        ];

        return $response;
    }

    protected function getCount(): int
    {
        $payload = [
            "Take" => 1,
            "Skip" => 0,
            "Page" => 1,
            "IncludeNew" => false,
            "MustHavePrice" => true,
            "CarBreaker" => "AT",
            "PartnerAccessLevel" => 2,
            "Filters" => [
                "SbrPartCode" => [
                    "3135",
                    "1021",
                    "1020",
                    "1022",
                    "4638",
                    "3235",
                    "3245",
                    "4573",
                    "7050",
                    "7051",
                    "7052",
                    "7070",
                ],
                "CarBreaker" => ["N"]

            ],
            "Action" => 2,
            "CreatedDate" => "2013-09-11T09:00"
        ];

        $options = $this->getAuthHeaders();
        $options['json'] = $payload;

        $response = $this->httpClient->request("post", "$this->apiUrl/autoteile/parts", $options);

        $data = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

        return $data['Count'];
    }

    protected function isPartSold(int $partId): bool
    {
        if ($this->tokenExpiresAt < now()->toIso8601String()) {
            $this->authenticate();
        }

        $payload = [
            "Take" => 500,
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
                    (string)$partId,
                ],
            ],
            "SortBy" => [
                "Created" => "ASC"
            ],
            "Action" => 3,
            // Add two days to the current date
            "DueDate" => now()->addDays(2)->toIso8601String(),
        ];

        $options = $this->getAuthHeaders();
        $options['json'] = $payload;

        $response = $this->httpClient->request("post", "$this->apiUrl/autoteile/parts", $options);
        $response = json_decode($response->getBody(), true);


        $count = $response['Count'];

        return $count === 0;
    }
}
