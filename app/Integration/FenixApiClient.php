<?php

namespace App\Integration;

use App\Integration\Types\FenixCarPart;
use App\Integration\Types\FenixCarPartImage;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class FenixApiClient implements FenixClientInterface
{
    private string $apiUrl;

    private string $username;

    private string $password;


    private Client $baseClient;

    private? string $tokenExpiration = null;

    private ?Client $client = null;

    public function __construct(
        string $apiUrl,
        string $username,
        string $password,
    )
    {
        $this->apiUrl = $apiUrl;
        $this->username = $username;
        $this->password = $password;

        $this->baseClient = new Client(['base_uri' => $this->apiUrl,
          'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
          ],
        ]);
    }


    /**
     * @return FenixCarPart[]
     * @throws GuzzleException
     */
    public function getAllParts(string $dismantler, ?string $dateFrom = null, ?string $dateTo = null): array
    {
        if (!$dateFrom) {
            $dateFrom = now()->subWeek();
        }

        if (!$dateTo) {
            $dateTo = now();
        }

        $parts = [];
        $skip = 0;
        $take = 1000;

        do {
            $response = $this->client()->request('GET', "$this->apiUrl/Fenix/GetAllParts", [
                'query' => [
                    'avd' => $dismantler,
                    'dateFrom' => $dateFrom,
                    'dateTo' => $dateTo,
                    'skip' => $skip,
                    'take' => $take,
                ],
            ]);

            $data = json_decode((string) $response->getBody(), true);

            foreach ($data['parts'] as $part) {
                $parts[] = FenixCarPart::fromData($part);
            }

            $skip += $take;
            $totalCount = $data['count'] ?? 0;

        } while ($skip < $totalCount);

        return $parts;
    }


    public function getRemovedParts(array $dismantlers, string $changedDate): array
    {
        $partIds = [];

        foreach ($dismantlers as $dismantler) {
            $response = $this->client()->request('POST', "$this->apiUrl/autoteile/removedparts", [
                'json' => [
                    'CarBreaker' => $dismantler,
                    'ReturnValue' => 'PartId',
                    'GetCause' =>  false,
                    'ChangedDate' => $changedDate,
                ]
            ]);

            $data = json_decode((string)$response->getBody(), true);

            $partIds = array_merge($partIds, $data);
        }

        return $partIds;
    }

    private function client(): Client
    {
        if (!$this->client || $this->isTokenExpired()) {
            $this->client = new Client([
                'base_uri' => $this->apiUrl,
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->getToken(),
               ],
            ]);
        }

        return $this->client;
    }

    private function getToken(): string
    {
        $response = $this->baseClient->request('POST', '/api/account', [
            'json' => [
                'username' => $this->username,
                'password' => $this->password,
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data['Token'];
    }

    private function isTokenExpired(): bool
    {
        if (!$this->tokenExpiration) {
            return true;
        }

        return strtotime($this->tokenExpiration) <= time();
    }
}
