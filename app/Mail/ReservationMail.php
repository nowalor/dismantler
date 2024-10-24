<?php

namespace App\Mail;

use App\Helpers\Constants\FenixDismantler;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationMail extends Mailable
{
    use Queueable, SerializesModels;

    private array $dismantleCompany;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        private string $dismantleCompanyCode,
        private string $dismantleId,
    )
    {
        $this->dismantleCompany = FenixDismantler::DISMANTLERS[$this->dismantleCompanyCode];
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            to: $this->dismantleCompany['email'],
            cc: config('mail.name'),
            subject: 'New part reservation',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.reservation',
            with: [
                'dismantleId' => $this->dismantleId,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
