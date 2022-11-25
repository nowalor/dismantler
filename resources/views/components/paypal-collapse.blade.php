<div class="w-50 mt-2">
    <img src="{{ asset('img/paypal-logo.png') }}" style="height: 50px;"
         alt="Paypal Logo">
    <p class="mb-3 text-muted fw-light">
        You will be redirected to a PayPal hosted checkout. There you can finish your purchase using your PayPal account.
    </p>

    <div class="pt-4">
        <button id="checkout-paypal-button" class="btn btn-primary w-100 btn-lg">
            Pay on paypal €{{ $carPart->price }}
        </button>
    </div>
</div>
