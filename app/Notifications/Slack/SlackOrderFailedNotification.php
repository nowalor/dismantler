<?php

namespace App\Notifications\Slack;

use App\Models\NewCarPart;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class SlackOrderFailedNotification extends Notification
{
    use Queueable;

    public const ERROR_TYPE_REQUEST_FAIL = 'request_fail';
    public const ERROR_TYPE_RESPONSE_EMPTY = 'response_empty';
    public const ERROR_TYPE_RESPONSE_INVALID = 'response_invalid';

    private string $message;

    public function __construct(
        private NewCarPart $carPart,
        private int        $statusCode,
        string             $errorType,
    )
    {
        if ($errorType === self::ERROR_TYPE_REQUEST_FAIL) {
            $this->message = "The request failed and the status code is: {$this->statusCode}";
        } elseif ($errorType === self::ERROR_TYPE_RESPONSE_EMPTY) {
            $this->message = "Response was empty";
        } elseif ($errorType === self::ERROR_TYPE_RESPONSE_INVALID) {
            $this->message = "Response was invalid and the reservation ID is missing";
        }
    }

    public function via($notifiable): array
    {
        return ['slack'];
    }

    public function toSlack($notifiable): SlackMessage
    {
        return (new SlackMessage)
            ->content($this->message());
    }

    private function message(): string
    {
        return "
    ⚠️ Order Error ⚠️\n
    *Message:* {$this->message}\n
    *Car Part:* {$this->carPart->name}\n
    *Car Part ID:* {$this->carPart->original_id}\n
    *External Reference:* {$this->carPart->article_nr}
    ";
    }
}
