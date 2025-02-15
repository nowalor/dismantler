<?php

namespace App\Integration;

use GuzzleHttp\Client;

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

            $partIds[] = array_merge($partIds, $data);
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
