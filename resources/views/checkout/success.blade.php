@extends('app')
@section('title', 'Payment successful')
@section('content')
    <div class="container h-100 pt-4">
        <div class="row h-100 justify-content-center pt-4">
            <div class="col-6 mx-auto text-center">
                <h1 class="display-3 fw-bolder">{{ __('payment-success.thank_you') }}</h1>
                <i class="fa fa-check text-success fs-1"></i>
                <p class="text-left">{{ __('payment-success.thank_you_for') }}.</p>
                <p>{{ __('payment-success.having_trouble') }}? <a href="{{ route('contact') }}">{{ __('payment-success.contact_us') }}</a></p>
            </div>
        </div>
    </div>
@endsection
