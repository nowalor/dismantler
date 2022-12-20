<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SellerPaymentSuccessfulMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
        //
    }

    public function envelope()
    {
        return new Envelope(
            from: config('mail.from.address'),
            to: config('mail.from.address'),
            subject: 'New order for a part',
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
