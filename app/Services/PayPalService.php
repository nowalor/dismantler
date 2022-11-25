<?php

namespace App\Services;

use App\Traits\ConsumeExternalServiceTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Models\Order;

class PayPalService
{
    use ConsumeExternalServiceTrait;

    protected $baseUri;
    protected $clientId;
    protected $clientSecret;

    public function __construct()
    {
        $this->baseUri = config('services.paypal.base_uri');
        $this->clientId = config('services.paypal.client_id');
        $this->clientSecret = config('services.paypal.client_secret');
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
        $credentials = base64_encode("$this->clientId:$this->clientSecret");

        return "Basic $credentials";
    }

    public function decodeResponse($response)
    {
        return json_decode($response);
    }

    public function handlePayment(array $paymentData, int $orderId)
    {
        $order = $this->createOrder($paymentData['value'], 'EUR');

        $orderLinks = collect($order->links);

        $approve = $orderLinks->where('rel', 'approve')->first();

        session()->put('approvalId', $order->id);
        session()->put('orderId', $orderId);


        return redirect($approve->href);
    }

    public function createOrder($value, $currency)
    {
        return $this->makeRequest(
            'POST',
            '/v2/checkout/orders',
            formParams: [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    0 => [
                        'amount' => [
                            'currency_code' => strtoupper($currency),
                            'value' => round($value * $factor = $this->resolveFactor($currency)) / $factor
                        ]
                    ]
                ],
                'application_context' => [
                    'brand_name' => config('app.name'),
                    'shipping_preference' => 'NO_SHIPPING',
                    'user_action' => 'PAY_NOW',
                    'return_url' => route('approval'),
                    'cancel_url' => route('cancelled'),
                ]
            ],
            isJsonRequest: true,
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

    public function handleApproval(): RedirectResponse | View
    {
        if (!session()->has('approvalId')) {
            return redirect()
                ->route('home')
                ->withErrors('We cannot capture the payment. Try again, please.');
        }

        if (!session()->has('orderId')) {
            return redirect()
                ->route('home')
                ->withErrors('We cannot capture the order. Try again, please.');
        }

        $approvalId = session()->get('approvalId');
        $orderId = session()->get('orderId');

        $order = Order::findOrFail($orderId);

        $payment = $this->capturePayment($approvalId);
        $order->update(['payment_provider_id' => $payment->id]);

        $name = $payment->payer->name->given_name;
        /* $payment = $payment->purchase_units[0]->payments->captures[0]->amount;
        $amount = $payment->amount;
        $currency = $payment->currrency_code; */
        // $payment->id


        // Save to orders table
        // Update car_parts table
        // Send email?
        return view('order-complete.index');
        /* return redirect()
            ->route('home')
            ->withSuccess(['payment' => "Thanks, $name"]); */
    }

    public function capturePayment($approvalId)
    {
        return $this->makeRequest(
            'POST',
            "/v2/checkout/orders/$approvalId/capture",
            headers: [
                'Content-Type' => 'application/json',
            ],
        );
    }
}
