<?php

namespace App\Notifications;

use App\Models\NewCarPart;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

class OrderSuccessWebsiteNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private NewCarPart $part)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
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
        return "Somebody has bought or attempted to buy the part with the article nr: {$this->part->article_nr}";
    }
}
