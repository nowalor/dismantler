<?php

namespace App\Services;

use App\Mail\SellerPaymentSuccessfulMail;
use App\Models\Order;
use App\Notifications\PaymentSuccessfulNotification;
use App\Traits\ConsumeExternalServiceTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class StripeService
{
    use ConsumeExternalServiceTrait;

    protected string $baseUri;
    protected string $key;
    protected string $secret;

    public function __construct()
    {
        $this->baseUri = config('services.stripe.base_uri');
        $this->key = config('services.stripe.key');
        $this->secret = config('services.stripe.secret');
    }

    public function resolveAuthorization(
        &$queryParams,
        &$formParams,
        &$headers
    ): void
    {
        $headers['Authorization'] = $this->resolveAccessToken();
    }

    public function resolveAccessToken(): string
    {
        return "Bearer $this->secret";
    }

    public function decodeResponse($response)
    {
        return json_decode($response);
    }

    public function handlePayment(Array $validated, int $orderId)
    {
        extract($validated);

        $intent = $this->createIntent(
            $value,
            'EUR',
            $payment_method,
        );

        session()->put('paymentIntentId', $intent->id);
        session()->put('orderId', $orderId);

        return redirect()->route('approval');
    }

    public function createIntent($value, $currency, $paymentMethod)
    {
        return $this->makeRequest(
            'POST',
            '/v1/payment_intents',
            [],
            formParams: [
                'amount' => round($value * $this->resolveFactor($currency)),
                'currency' => strtolower($currency),
                'payment_method' => $paymentMethod,
                'confirmation_method' => 'manual',
            ],
        );
    }

    public function resolveFactor(string $currency): int
    {
        $zeroDecimalCurrencies = ['JPY'];

        if (in_array(strtoupper($currency), $zeroDecimalCurrencies)) {
            return 1;
        }

        return 100;
    }

    public function handleApproval(): RedirectResponse
    {
        if (!session()->has('paymentIntentId')) {
            return redirect()
                ->route('home')
                ->withErrors('We cannot capture the payment. Try again, please.');
        }

        if (!session()->has('orderId')) {
            return redirect()
                ->route('home')
                ->withErrors('We cannot capture the order. Try again, please.');
        }

        $paymentIntentId = session()->get('paymentIntentId');
        $orderId = session()->get('orderId');

        $order = Order::findOrFail($orderId);

        $confirmation = $this->confirmPayment($paymentIntentId);

        $order->update([
            'payment_provider_id' => $confirmation->id,
        ]);

        if (!$confirmation->status === 'succeeded') {
            return redirect()
                ->route('home')
                ->withErrors('We cannot capture the payment. Try again, please.');
        }

        $name = $confirmation->charges->data[0]->billing_details->name;
        $currency = strtoupper($confirmation->currency);
        $amount = $confirmation->amount / $this->resolveFactor($currency);

        // $confirmation->id

        // Send emails
        Mail::send(new SellerPaymentSuccessfulMail($order));

        return redirect()
            ->route('checkout.success');
    }

    public function confirmPayment($paymentIntentId)
    {
        return $this->makeRequest(
            'POST',
            "/v1/payment_intents/$paymentIntentId/confirm",
        );
    }
}
