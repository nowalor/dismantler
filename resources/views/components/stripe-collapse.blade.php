@push('styles')
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
@endpush

<div>
    <label for="card-element" class="mt-3">
        Credit details
    </label>
    <div id="cardElement">
        <!-- Elements will create input elements here -->
    </div>

    <!-- We'll put the error messages in this element -->
    <small class="form-text text-muted" id="cardErrors" role="alert"></small>
    <input type="hidden" name="payment_method" id="paymentMethod">
</div>

@push('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = new Stripe('{{ config('services.stripe.key') }}')

        const elements = stripe.elements({
            locale: 'en',
        })

        const cardElement = elements.create('card')

        cardElement.mount('#cardElement')
    </script>
    <script>
        const form = document.getElementById('payment-form')
        const payButton = document.getElementById('payment-button')

        payButton.addEventListener('click', async (e) => {
            e.preventDefault()
            alert('prevented default...')
            if (form.elements.payment_platform.value === "{{ $paymentPlatform->id }}") {
                const {paymentMethod, error} = await stripe.createPaymentMethod(
                    'card',
                    cardElement,
                    {
                        billing_details: {

                        },
                    }
                )

                if (error) {
                    const displayError = document.getElementById('cardErrors')

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
