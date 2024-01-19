<?php

namespace App\Mail;

use App\Helpers\Constants\FenixDismantler;
use App\Models\NewCarPart;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
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
        private string $fenixId,
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
            subject: 'Reservation Mail',
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
            view: 'view.name',
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
