@extends('app')
@section('title', 'Buy part now ' . $carPart->name)
@section('content')
    <div class="container pb-4 pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href=" {{ route('home') }} ">Home</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('car-parts.index') }}">Car parts</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('car-parts.show', $carPart) }}">{{ $carPart->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
        <div>
            <div class="py-5 text-center col-8 mx-auto">
                <!--   <img class="d-block mx-auto mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
                <img style="width: 45px;" src="{{ asset('img/check-out-icon.png') }}"/>
                <h2>Checkout</h2>
                <p class="text-muted fw-light">This is the checkout page for part {{$carPart->name}}. After you fill in
                    the form below
                    with your payment and delivery information the part will be delivered to you.</p>
            </div>

            <div class="row g-5">
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Your cart <i class="fa fa-shopping-cart text-primary"></i>
</span>
                        <span class="badge bg-primary rounded-pill">1</span>
                    </h4>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">{{ $carPart->name }}</h6>

                            </div>
                            <span class="text-muted">€{{ $carPart->price }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (EUR)</span>
                            <strong>€{{ $carPart->price }}</strong>
                        </li>
                    </ul>

                </div>
                <div class="col-md-7 col-lg-8">

                    <h4 class="mb-3">Delivery information <i class="fa fa-car"></i>
                    </h4>
                    <form action="{{ route('pay', $carPart) }}" class="needs-validation" novalidate id="payment-form"
                          method="POST">
                        @csrf
                        <input type="hidden" name="car_part_id" value="{{ $carPart->id }}"/>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="checkout_name" class="form-label">Name*</label>
                                <input name="name" type="text" class="form-control" id="checkout_name"
                                       placeholder="Please enter your name"
                                       value="" required>
                                <div class="invalid-feedback">
                                    Valid name is required.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="checkout_email" class="form-label">Email*</label>
                                <input name="email" type="email" class="form-control" id="checkout_email"
                                       placeholder="you@example.com">
                                <div class="invalid-feedback">
                                    Please enter a valid email address for shipping updates.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="checkout_address" class="form-label">Address</label>
                                <input name="address" type="text" class="form-control" id="checkout_address"
                                       placeholder="1234 Main St"
                                       required>
                                <div class="invalid-feedback">
                                    Please enter your shipping address.
                                </div>
                            </div>

                            <!-- <div class="col-md-5">
                                <label for="country" class="form-label">Country</label>
                                <select name="country" class="form-select" id="country" required>
                                    <option value="">Choose...</option>
                                    <option value="US">United States</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid country.
                                </div>
                            </div> -->

                            <div class="col-md-3">
                                <label for="checkout_town" class="form-label">Town</label>
                                <input name="town" type="text" class="form-control" id="checkout_town" placeholder=""
                                       required>
                                <div class="invalid-feedback">
                                    Town code required.
                                </div>
                            </div>


                            <div class="col-md-3">
                                <label for="checkout_zip" class="form-label">Zip</label>
                                <input name="zip_code" type="text" class="form-control" id="checkout_zip" placeholder=""
                                       required>
                                <div class="invalid-feedback">
                                    Zip code required.
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h4 class="mb-3">Payment <i class="fa fa-credit-card"></i></h4>


                        <p>Pay with...</p>

                        <div class="mb-3" id="toggler">
                            <div class="btn-group btn-group-toggle d-flex gap-2 align-items-center"
                                 data-toggle="buttons">
                                <label data-bs-target="#StripeCollapse"
                                       data-bs-toggle="collapse"
                                       for="payment_platform_stripe"
                                >
                                    <button class="btn btn-primary disabled" id="checkout-card-button">
                                        <i class="fa fa-credit-card"></i>
                                        Card
                                    </button>
                                    <input type="radio" name="payment_platform" class="invisible" value="2"
                                           id="payment_platform_stripe">
                                </label>
                                or
                                <label data-bs-target="#PaypalCollapse"
                                       data-bs-toggle="collapse"
                                       for="payment_platform_paypal"

                                >
                                    <button id="checkout-paypal-button" class="btn btn-primary disabled"
                                            style="background-color: #FFC439; border: none;">
                                        <img src="{{ asset('img/paypal-logo.png') }}" style="height: 24px;"
                                             alt="Paypal Logo">
                                    </button>
                                    <input type="radio" name="payment_platform" class="invisible" value="1"
                                           id="payment_platform_paypal">
                                </label>
                            </div>

                            @foreach($paymentPlatforms as $paymentPlatform)
                                <div
                                    id="{{ $paymentPlatform->name }}Collapse"
                                    class="collapse"
                                    data-bs-parent="#toggler"
                                >
                                    @include('components.' . strtolower($paymentPlatform->name) . '-collapse')
                                </div>
                            @endforeach
                            <input type="hidden" />
                        </div>

                        <hr class="my-4">

                        <!-- <button id="payment-button" class="w-100 btn btn-primary btn-lg" type="submit">Buy now
                            €{{ $carPart->price }}</button> -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($errors->any())
        @foreach($errors->all() as $error)
            {{ $error }}
        @endforeach
    @endif
@endsection

@push('js')
    <script>
        const checkoutButtonCardEl = document.getElementById('checkout-card-button')
        const checkoutButtonPaypalEl = document.getElementById('checkout-paypal-button')

        checkoutButtonCardEl.addEventListener('click', (event) => {
            event.preventDefault()
            if (checkoutButtonCardEl.classList.contains('active')) {
                checkoutButtonCardEl.classList.add('disabled')
                checkoutButtonCardEl.classList.remove('active')
            } else {
                checkoutButtonCardEl.classList.remove('disabled')
                checkoutButtonCardEl.classList.add('active')
            }

            checkoutButtonPaypalEl.classList.add('disabled')
            checkoutButtonPaypalEl.classList.remove('active')
        })

        checkoutButtonPaypalEl.addEventListener('click', (event) => {
            event.preventDefault()

            if (checkoutButtonPaypalEl.classList.contains('active')) {
                checkoutButtonCardEl.classList.remove('disabled')
                checkoutButtonCardEl.classList.add('active')
            } else {
                checkoutButtonCardEl.classList.add('disabled')
                checkoutButtonCardEl.classList.remove('active')
            }

            checkoutButtonPaypalEl.classList.remove('disabled')
            checkoutButtonPaypalEl.classList.add('active')
        })
    </script>
@endpush
