<?php

namespace App\Notifications\Slack;

use App\Models\NewCarPart;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

const NOTIFICATION_TYPE_RESERVATION = 'reservation';
const NOTIFICATION_TYPE_ORDER = 'order';

class SlackOrderSuccessNotification extends Notification
{
    use Queueable;

    private string $appUrl;

    public function __construct(
        private array $partData,
        private string $reservationId,
        private string $reservationUuid,
    )
    {
        $this->appUrl = config('app.url');
    }

    public function via($notifiable): array
    {
        return ['slack'];
    }

    public function toSlack(): SlackMessage
    {
        return (new SlackMessage)
            ->content($this->message());
    }

    private function message(): string
    {
        logger($this->partData);

        return "
    🔥 New Reservation 🔥\n
    *Article Number:* {$this->partData['article_nr']}\n
    *Reservation ID:* {$this->reservationId}\n
    Billing information:
    - *Name:* {$this->partData['billing_information']['firstname']} {$this->partData['billing_information']['surname']}
    - *Address:* {$this->partData['billing_information']['street']}, {$this->partData['billing_information']['zip']} {$this->partData['billing_information']['city']}, {$this->partData['billing_information']['country']}
    - *Email:* {$this->partData['billing_information']['email']}
    - *Phone:* {$this->partData['billing_information']['phone']}

    Shipping information:
    - *Name:* {$this->partData['shipping_information']['firstname']} {$this->partData['shipping_information']['surname']}
    - *Address:* {$this->partData['shipping_information']['street']}, {$this->partData['shipping_information']['zip']} {$this->partData['shipping_information']['city']}, {$this->partData['shipping_information']['country']}
    - *Phone:* {$this->partData['shipping_information']['phone']}


    Remove reservation link:
    - *Link:* {$this->appUrl}/reservations/{$this->reservationUuid}
    ";
    }
}
