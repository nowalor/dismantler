<?php

namespace App\Console\Commands\Base;

use App\Models\NewCarPart;
use App\Notifications\Slack\SlackOrderFailedNotification;
use App\Services\SlackNotificationService;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
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

    public function reservePart(NewCarPart $part): bool|array
    {
        if (!isset($this->token)) {
            $this->authenticate();
        }

        if ($this->tokenExpiresAt < now()->toIso8601String()) {
            $this->authenticate();
        }

        $payload = [
            "Reservations" => [
                [
                    'Id' => 0,
                    'PartId' => $part->original_id,
                    'Type' => 3,
                    'CarBreaker' => 'AT',
                    'ExternalReference' => $part->article_nr,
                    'ExternalSourceName' => 'autoteile',
                    'DueDate' => now()->addDays(2)->toIso8601String(),
                ],
            ]
        ];

        $options = $this->getAuthHeaders();
        $options['json'] = $payload;


        try {
            $response = $this->httpClient->request("post", "$this->apiUrl/autoteile/savereservations", $options);

            $statusCode = $response->getStatusCode();

            $data = json_decode($response->getBody(), true);

            if ($statusCode !== 200) {
                $this->notificationService->notify(
                    SlackNotificationService::ORDER_FAILED,
                    $part,
                    statusCode: $statusCode
                );
                logger($data);

                return false;
            } elseif (empty($data)) {
                $this->notificationService->notify(
                    SlackNotificationService::ORDER_FAILED,
                    $part,
                    errorType: SlackOrderFailedNotification::ERROR_TYPE_RESPONSE_EMPTY,
                );
                logger($data);

                return false;
            } elseif ($data[0]['Id'] === 0) {
                $this->notificationService->notify(
                    SlackNotificationService::ORDER_FAILED,
                    $part,
                    errorType: SlackOrderFailedNotification::ERROR_TYPE_RESPONSE_INVALID,
                );

                logger($data);
                return false;
            }
        } catch (Exception $e) {
            $this->notificationService->notify(
                SlackNotificationService::ORDER_FAILED,
                $part,
            );

            logger($e->getMessage());

            return false;
        }

        logger($data);

        return [
            'Id' => $data[0]['Id'],
        ];
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    protected function getParts(): array
    {
        if ($this->tokenExpiresAt < now()->toIso8601String()) {
            $this->authenticate();
        }

        $filters = [
            "SbrPartCode" => ["7201", "7280", "7704", "7705", "7706", "7868", "7860", "7070", "7145"],
            "CarBreaker" => ["N"],
        ];

        $parts = [];

        $count = $this->getCount();
        $increment = 500;
        $page = 1;

       // Keep incrementing take by 500 until we have no parts left
        for ($skip = 0; $skip < $count + $increment; $skip += $increment) {
            logger("Skip: $skip");
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
                "SbrPartCode" => ["7201", "7280", "7704", "7705", "7706", "7868", "7860", "7070", "7145"],
                "CarBreaker" => ["F"]

            ],
            "Action" => 2,
            "CreatedDate" => "2013-09-11T09:00"
        ];

        $options = $this->getAuthHeaders();
        $options['json'] = $payload;

        $response = $this->httpClient->request("post", "$this->apiUrl/autoteile/parts", $options);
        logger($response->getStatusCode());

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
                    "$partId",
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
