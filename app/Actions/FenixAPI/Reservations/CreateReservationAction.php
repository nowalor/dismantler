<?php

namespace App\Actions\FenixAPI\Reservations;

use App\Actions\FenixAPI\FenixApiAction;
use App\Models\NewCarPart;
use App\Models\Reservation;
use App\Notifications\Slack\SlackOrderFailedNotification;
use App\Services\SlackNotificationService;
use Exception;

class CreateReservationAction extends FenixApiAction
{
    private SlackNotificationService $notificationService;

    public function __construct()
    {
        parent::__construct();

        $this->notificationService = new SlackNotificationService();
    }

    public function execute(NewCarPart $part): bool | Reservation
    {
        $this->authenticate();

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
            $response = $this->httpClient->request(
                "post",
                "$this->apiUrl/autoteile/savereservations",
                $options
            );

            $statusCode = $response->getStatusCode();

            if ($statusCode !== 200) {
                $this->notificationService->notify(
                    SlackNotificationService::ORDER_FAILED,
                    $part,
                    statusCode: $statusCode
                );

                return false;
            }

            $data = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

            if (empty($data)) {
                $this->notificationService->notify(
                    SlackNotificationService::ORDER_FAILED,
                    $part,
                    errorType: SlackOrderFailedNotification::ERROR_TYPE_RESPONSE_EMPTY,
                );

                return false;
            }

            if ($data[0]['Id'] === 0) {
                $this->notificationService->notify(
                    SlackNotificationService::ORDER_FAILED,
                    $part,
                    errorType: SlackOrderFailedNotification::ERROR_TYPE_RESPONSE_INVALID,
                );


                return false;
            }
        } catch (Exception) {
            $this->notificationService->notify(
                SlackNotificationService::ORDER_FAILED,
                $part,
            );

            return false;
        }

        return Reservation::create([
            'car_part_id' => $part->id,
            'reservation_id' => $data[0]['Id'],
        ]);
    }
}
