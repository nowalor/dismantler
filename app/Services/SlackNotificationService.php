<?php

namespace App\Services;

use App\Models\NewCarPart;
use App\Notifications\SlackOrderFailedNotification;
use Illuminate\Support\Facades\Notification;

class SlackNotificationService
{
    public const ORDER_FAILED = 'order_failed';
    public const ORDER_SUCCESS = 'order_success';

    public function notify(
        string     $type,
        NewCarPart $carPart = null,
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

    private function notifyOrderSuccess(): void
    {
       Notification::route(
            'slack',
            config('services.slack.order_success_webhook_url'),
        )->notify(new SlackOrderSuccessNotification()
       );
    }
}
