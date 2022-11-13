@extends('app')
@section('title', 'Thank you for your order')
@section('content')
    <div class="container">
        <div>
            <div class="py-5 text-center">
                <!--   <img class="d-block mx-auto mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
                <h2>Checkout</h2>
                <p class="lead">Below is an example form built entirely with Bootstrap’s form controls. Each required
                    form group has a validation state that can be triggered by attempting to submit the form without
                    completing it.</p>
            </div>

            <div class="row g-5">
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Your cart</span>
                        <span class="badge bg-primary rounded-pill">3</span>
                    </h4>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">{{ $carPart->name }}</h6>
                                <small class="text-muted">Quantity: 3</small>
                            </div>
                            <span class="text-muted">$12</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Second product</h6>
                                <small class="text-muted">Brief description</small>
                            </div>
                            <span class="text-muted">$8</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">Third item</h6>
                                <small class="text-muted">Brief description</small>
                            </div>
                            <span class="text-muted">$5</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <div class="text-success">
                                <h6 class="my-0">Promo code</h6>
                                <small>EXAMPLECODE</small>
                            </div>
                            <span class="text-success">−$5</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (USD)</span>
                            <strong>$20</strong>
                        </li>
                    </ul>

                </div>
                <div class="col-md-7 col-lg-8">
                    <h4 class="mb-3">Billing address</h4>
                    <form action="{{ route('pay', $carPart) }}" class="needs-validation" novalidate id="payment-form"
                          method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label">Name*</label>
                                <input name="name" type="text" class="form-control" id="name" placeholder="Please enter your name"
                                       value="" required>
                                <div class="invalid-feedback">
                                    Valid name is required.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label">Email*</label>
                                <input name="email" type="email" class="form-control" id="email" placeholder="you@example.com">
                                <div class="invalid-feedback">
                                    Please enter a valid email address for shipping updates.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <input name="address" type="text" class="form-control" id="address" placeholder="1234 Main St"
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
                                <label for="zip" class="form-label">Town</label>
                                <input name="town" type="text" class="form-control" id="zip" placeholder="" required>
                                <div class="invalid-feedback">
                                    Town code required.
                                </div>
                            </div>


                            <div class="col-md-3">
                                <label for="zip" class="form-label">Zip</label>
                                <input name="zip_code" type="text" class="form-control" id="zip" placeholder="" required>
                                <div class="invalid-feedback">
                                    Zip code required.
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h4 class="mb-3">Payment</h4>

                        <div class="mb-3" id="toggler">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                @foreach($paymentPlatforms as $paymentPlatform)

                                    <label class="btn btn-outline-secondary rounded mt p-1"
                                           data-bs-target="#{{ $paymentPlatform->name  }}Collapse"
                                           data-bs-toggle="collapse"
                                    >
                                        <div>{{ $paymentPlatform->name }}</div>
                                        <input type="radio" name="payment_platform"
                                               value="{{ $paymentPlatform->id }}" required>
                                        <img src="{{ asset(strtolower($paymentPlatform->name) . '.jpg') }}"
                                             class="img-thumbnail">
                                    </label>
                                @endforeach
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
                        </div>

                        <hr class="my-4">

                        <button id="payment-button" class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
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
