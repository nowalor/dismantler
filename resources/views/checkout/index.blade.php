@extends('app')
@section('title', "Checkout - {$carPart->pageTitle()}")
@section('content')
    @if($carPart->getLocalizedPrice()['requires_request'])
        <h1>Currently it's not possible to buy the part via checkout in your location. Please contact us if you are interested in buying this part</h1>
    @else
    <div class="container pb-4 pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                @foreach ($checkoutBreadcrumbs as $breadcrumb)
                    @if ($loop->last)
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $breadcrumb['name'] }}
                        </li>
                    @else
                        <li class="breadcrumb-item">
                            <a href="{{ $breadcrumb['route'] }}">
                                {{ $breadcrumb['name'] }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>
        <div>
            <div class="py-5 text-center col-8 mx-auto">
                <!--   <img class="d-block mx-auto mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
                <img style="width: 45px;" src="{{ asset('img/check-out-icon.png') }}"/>
                <h2>{{ __('checkout.checkout') }}</h2>
                <p class="text-muted fw-light">{{ __('checkout.this_is_the_checkout_page_for_your_order') }}</p>
            </div>

            <div class="row g-5">
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">{{ __('checkout.your_cart') }} <i class="fa fa-shopping-cart text-primary"></i>
</span>
                        <span class="badge bg-primary rounded-pill">1</span>
                    </h4>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">  {{ Str::of($carPart->new_name)->limit(34) }}</h6>
                            </div>
                            <span class="text-muted">{{ $carPart->full_price . $carPart->getLocalizedPrice()['symbol']}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total {{ $carPart->getLocalizedPrice()['symbol'] }}</span>
                            <strong>{{ $carPart->full_price . $carPart->getLocalizedPrice()['symbol']}}</strong>
                        </li>
                    </ul>

                </div>
                <div class="col-md-7 col-lg-8">

                    <h4 class="mb-3">{{ __('checkout.delivery_information') }} <i class="fa fa-car"></i>
                    </h4>
                    <form action="{{ route('pay', $carPart) }}" class="needs-validation" novalidate id="payment-form"
                          method="POST">
                        @csrf
                        <input type="hidden" name="car_part_id" value="{{ $carPart->id }}"/>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="checkout_name" class="form-label">{{ __('checkout.name') }}*</label>
                                <input name="name" type="text" class="form-control" id="checkout_name"
                                       placeholder="{{ __('checkout.please_enter_your_name') }}"
                                       value="" required>
                                <div class="invalid-feedback">
                                    Valid name is required.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="checkout_email" class="form-label">{{ __('checkout.email') }}*</label>
                                <input name="email" type="email" class="form-control" id="checkout_email"
                                       placeholder="{{ __('checkout.email') }}"
                                       />
                                <div class="invalid-feedback">
                                    Please enter a valid email address.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="checkout_address" class="form-label">{{ __('checkout.address') }}</label>
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
                                <label for="checkout_town" class="form-label">{{ __('checkout.town') }}</label>
                                <input name="town" type="text" class="form-control" id="checkout_town" placeholder=""
                                       required>
                                <div class="invalid-feedback">
                                    Town code required.
                                </div>
                            </div>


                            <div class="col-md-3">
                                <label for="checkout_zip" class="form-label">{{ __('checkout.zip') }}</label>
                                <input name="zip_code" type="text" class="form-control" id="checkout_zip" placeholder=""
                                       required>
                                <div class="invalid-feedback">
                                    Zip code required.
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h4 class="mb-3">Payment <i class="fa fa-credit-card"></i></h4>


           {{--             <p>Pay with...</p>--}}

                        <div class="mb-3" id="toggler">
                      {{--      <div class="btn-group btn-group-toggle d-flex gap-2 align-items-center"
                                 data-toggle="buttons">
                                <label data-bs-target="#StripeCollapse"
                                       data-bs-toggle="collapse"
                                       for="payment_platform_stripe"
                                >
                                    <button class="btn btn-primary disabled" id="checkout-card-button">
                                        <i class="fa fa-credit-card"></i>
                                        Card
                                    </button>
                                    <input type="radio" name="payment_platform" class="invisible" value="1"
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
                                    <input type="radio" name="payment_platform" class="invisible" value="2"
                                           id="payment_platform_paypal">
                                </label>
                            </div>--}}
                            <input type="radio" name="payment_platform" class="invisible" value="1"
                                   id="payment_platform_stripe" checked>
                            @foreach($paymentPlatforms as $paymentPlatform)
                                @if($paymentPlatform->name === 'Stripe')
                                <div
                                    id="{{ $paymentPlatform->name }}Collapse"

                                >
                                    @include('components.' . strtolower($paymentPlatform->name) . '-collapse')
                                </div>
                                @endif
                            @endforeach
                            <input type="hidden" />
                        </div>

                        <hr class="my-4">
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
