<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;
    private string $senderEmail;
    private string $senderName;
    private string $senderSubject;
    private string $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $payload)
    {
        $this->senderEmail = $payload['email'];
        $this->senderName = $payload['name'];
        $this->senderSubject = $payload['subject'];
        $this->message = $payload['message'];
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: New Address(
                'nikulasoskarsson@gmail.com', "Currus Connect Contact Form",
            ),
            subject: "FROM WEBSITE: $this->senderSubject",
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
            markdown: 'mail.contact-us-mail',
            with: [
                'senderName' => $this->senderName,
                'senderEmail' => $this->senderEmail,
                'senderSubject' => $this->senderSubject,
                'message' => $this->message,
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
