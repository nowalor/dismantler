@extends('app')
@section('title', 'Payment successful')
@section('content')
    <div class="container h-100 pt-4">
        <div class="row h-100 justify-content-center pt-4">
            <div class="col-6 mx-auto text-center">
                <h1 class="display-3 fw-bolder">Thank you</h1>
                <i class="fa fa-check text-success fs-1"></i>
                <p class="text-left">Thank you for your purchase. You should have received an email with more
                    information and your recipt.</p>
                <p>Having trouble? <a href="{{ route('contact') }}">Contact us</a></p>
            </div>
        </div>
    </div>
@endsection
