@extends('app')
@section('content')
    <div class="d-flex">
        <img style="height: calc(100vh - 56px); object-fit: cover;" class="w-50"
             src="{{ asset('img/car-banner2.jpg') }}" alt="">
        <div class="container pt-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href=" {{ route('landingpage') }} ">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact us</li>
                </ol>
            </nav>
            <h1 class="pt-3 text-center">Contact us</h1>
            <p class="text-center text-secondary">And we will get back to you as soon as possible</p>
            <p class="text-center fw-light text-secondary">Before you contact us please check if there is already an
                answer to your question in our <a
                    href="{{ route('faq') }}" class="link-info">FAQ</a></p>
            <form action="{{ route('contact.send') }}" method="POST" class="col-8 mx-auto">
                @csrf
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="mb-2">
                    <label for="name">Name*</label>
                    <input required type="text" class="form-control" name="name" id="name"
                           placeholder="Enter your name">
                </div>
                <div class="mb-2">
                    <label for="email">Subject*</label>
                    <input required type="text" class="form-control" name="email" id="email" placeholder="Enter email">
                </div>
                <div class="mb-2">
                    <label for="email">Email address*</label>
                    <input required type="email" class="form-control" name="email" id="email" placeholder="Enter email">
                </div>
                <div class="mb-4">
                    <label for="message">Message*</label>
                    <textarea required class="form-control" name="message" id="message"
                              style="height: 12rem;"></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-large w-100">Submit</button>
            </form>
        </div>
    </div>
@endsection
