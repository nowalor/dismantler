<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SellerPaymentSuccessfulMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function envelope()
    {
        return new Envelope(
            from: 'nikulasoskarsson@gmail.com',
            to:'nikulasoskarsson@gmail.com',
            subject: 'Seller Payment Successful Mail',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.sellers.payment.success',
        );
    }

    public function attachments()
    {
        return [];
    }
}
