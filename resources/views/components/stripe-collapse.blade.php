<div class="w-50 mt-2">
    <input type="hidden" name="payment_method" id="paymentMethod">

@if(session('error'))
    {{ session('error') }}
@endif

    <img src="{{ asset('img/stripe-logo.png') }}" style="height: 60px;"
         alt="Paypal Logo">
    <p class="mb-3 text-muted fw-light">{{ __('checkout.pay_with_credit_or_debit') }}.</p>
    <div class="mb-3">
        <label>{{ __('checkout.cardholder_name') }}*</label>
        <input type="text" name="stripe_name" class="form-control"/>
    </div>

    <div class="mb-3">
        <label>{{ __('checkout.cardholder_email') }}*</label>
        <input type="text" name="stripe_email" class="form-control"/>
    </div>

    <div class="mb-3">
        <label for="card-element">{{ __('checkout.card') }}*</label>
        <div id="cardElement" class="form-control" style='height: 2.4em; padding-top: .7em;'>
            <!-- A Stripe Element will be inserted here. -->
        </div>
    </div>

    <div class="mb-3">
        <label>{{ __('checkout.cardholder_address') }}*</label>
        <input type="text" class="form-control"/>
    </div>

    <div class="d-flex mb-3 gap-2">
        <div>
            <label>{{ __('checkout.cardholder_city') }}*</label>
            <input type="text" class="form-control"/>
        </div>
        <div>
            <label>{{ __('checkout.cardholder_postal_code') }}*</label>
            <input type="text" class="form-control"/>
            </div>
    </div>
    <div class="pt-3">
        <button id="payment-button" class="w-100 btn btn-primary btn-lg" type="submit">{{ __('checkout.buy_now') }}</button>
    </div>
</div>

@push('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = new Stripe('{{ config('services.stripe.key') }}')

        const elements = stripe.elements({
            locale: 'en',
        })

        const cardElement = elements.create('card', {
            hidePostalCode: true
        })

        cardElement.mount('#cardElement')
    </script>
    <script>
        const form = document.getElementById('payment-form')
        const payButton = document.getElementById('payment-button')

        payButton.addEventListener('click', async (e) => {
            e.preventDefault()

            if (1 === {{ $paymentPlatform->id }}) {
                const buyerName = document.getElementById('checkout_name').value
                const buyerEmail = document.getElementById('checkout_email').value
                const address = document.getElementById('checkout_address').value
                const town = document.getElementById('checkout_town').value
                const zipCode = document.getElementById('checkout_zip').value

                const {paymentMethod, error} = await stripe.createPaymentMethod(
                    'card',
                    cardElement,
                    {
                        billing_details: {
                            name: buyerName,
                            email: buyerEmail,
                            address: {
                                city: town,
                                country: null,
                                line1: address,
                                postal_code: zipCode,
                            },
                        },
                    }
                )


                if (error) {
                    const displayError = document.getElementById('cardErrors')
                    console.log('error', error)
                    displayError.textContent = error.message
                } else {
                    const tokenInput = document.getElementById('paymentMethod')

                    tokenInput.value = paymentMethod.id


                    form.submit()
                }
            }
        })

    </script>

@endpush()
