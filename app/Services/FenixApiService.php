<?php

namespace App\Services;

use App\Models\Reservation;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

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

    /**
     * @throws \HttpException
     * @throws GuzzleException
     */
    public function getParts(array $options) //: array
    {
        if ($this->tokenExpiresAt < now()->toIso8601String()) {
            $this->authenticate();
        }
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

        $payload = array_merge($payload, $options);

        try {
            $options = $this->getAuthHeaders();
            $options['json'] = $payload;

            $response = $this->httpClient->request("post", "$this->apiUrl/autoteile/parts", $options);

            $response = json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            logger($e->getMessage());
            logger($e->getTraceAsString());

            throw new \HttpException($e->getMessage());
        }

        return $response;
    }

    protected function getAuthHeaders(): array
    {
        return [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ],
        ];
    }

    private function authenticate(): void
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

    public function getReservation(int $reservationId): \Illuminate\Http\JsonResponse|ResponseInterface
    {
        try {
            $this->authenticate();

            $payload = [
                'ReservationId' => $reservationId,
                "CarBreaker" => "AT",
            ];

            $options = $this->getAuthHeaders();
            $options['json'] = $payload;

            $response = $this->httpClient->request(
                'POST',
                "$this->apiUrl/autoteile/getreservation",
                $options,
            );

            logger("response");
            logger($response->getBody()->getContents());
        } catch(GuzzleException $e) {
            logger($e->getMessage());
            logger($e->getTraceAsString());

            if($e->getCode() === 404) {
                return response()->json([
                    'message' => 'Reservation not found',
                ], 404);
            }

            return response()->json([
                'message' => 'Something went wrong',
            ], 500);
        }

        return $response;
    }

    public function hasReservation(int $reservationId) : bool
    {
        $reservation = $this->getReservation($reservationId);

        return $reservation->getStatusCode() === 200;
    }

    public function removeReservation(Reservation $reservation): void
    {
        $this->authenticate();

        $payload = [
          'Reservations' => [
              [
                  'Id' => $reservation->reservation_id,
                  'PartId' => $reservation->carPart->original_id,
                  'Type' => 3,
                  'CarBreaker' => 'AT',
              ],
          ],
        ];

        logger("payload test");
        logger($payload);

        $options = $this->getAuthHeaders();
        $options['json'] = $payload;

        $this->httpClient->request(
            'POST',
            "$this->apiUrl/autoteile/removereservations",
            $options,
        );
    }
}
