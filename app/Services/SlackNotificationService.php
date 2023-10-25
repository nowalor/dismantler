<?php

namespace App\Services;

use App\Models\NewCarPart;
use App\Notifications\Slack\SlackOrderFailedNotification;
use App\Notifications\Slack\SlackOrderSuccessNotification;
use Illuminate\Support\Facades\Notification;

class SlackNotificationService
{
    public const ORDER_FAILED = 'order_failed';
    public const ORDER_SUCCESS = 'order_success';

    public function notify(
        string     $type,
        NewCarPart $carPart = null,
        array $data = [],
        int        $statusCode = 200,
        string $errorType = SlackOrderFailedNotification::ERROR_TYPE_REQUEST_FAIL,
    ): void
    {
        if ($type === self::ORDER_FAILED) {
            $this->notifyOrderFailed(
                $carPart,
                $statusCode,
                $errorType
            );
        } elseif ($type === self::ORDER_SUCCESS) {
            $this->notifyOrderSuccess($carPart);
        }
    }

    private function notifyOrderFailed(
        NewCarPart $carPart,
        int $statusCode,
        string $errorType
    ): void
    {
        Notification::route(
            'slack',
            config('services.slack.order_failed_webhook_url'),
        )->notify(new SlackOrderFailedNotification(
            $carPart,
            $statusCode,
            $errorType,
        ));
    }

    public function notifyOrderSuccess(
        array $partData,
        string | null $reservationId,
        string | null $reservationUuid
    ): void
    {
       Notification::route(
            'slack',
            config('services.slack.order_webhook_url'),
        )->notify(new SlackOrderSuccessNotification($partData, $reservationId, $reservationUuid)
       );
    }
}
