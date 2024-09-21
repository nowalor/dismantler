@extends('app')
@section('content')
    <div class="d-flex flex-column flex-md-row pb-4">
        <!-- Image section, visible only on medium and larger screens -->
        <img style="height: calc(100vh - 56px); object-fit: cover;" class="w-50 d-none d-md-block"
             src="{{ asset('img/car-banner2.jpg') }}" alt="">
        
        <!-- Form section -->
        <div class="container pt-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href=" {{ route('landingpage') }} ">{{__('home')}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{__('contact-us')}}</li>
                </ol>
            </nav>
            <h1 class="pt-3 text-center">{{__('contact-us')}}</h1>
            <p class="text-center text-secondary">{{__('contact-asap')}}</p>
            <p class="text-center fw-light text-secondary">{{__('contact-before')}} <a
                    href="{{ route('faq') }}" class="link-info">FAQ</a></p>
            <form action="{{ route('contact.send') }}" method="POST" class="col-12 col-md-8 mx-auto">
                @csrf
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif

                @if(session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif
                <div class="mb-2 mt-3">
                    <label for="name">{{__('contact-form-name')}}</label>
                    <input required type="text" class="form-control" name="name" id="name"
                           placeholder="{{__('contact-placeholder-name')}}">
                </div>
                <div class="mb-2">
                    <label for="email">{{__('contact-form-subject')}}</label>
                    <input required type="text" class="form-control" name="email" id="email" placeholder="{{__('contact-placeholder-subject')}}">
                </div>
                <div class="mb-2">
                    <label for="email">{{__('contact-form-email')}}</label>
                    <input required type="email" class="form-control" name="email" id="email" placeholder="{{__('contact-placeholder-email')}}">
                </div>
                <div class="mb-4">
                    <label for="message">{{__('contact-form-message')}}</label>
                    <textarea required class="form-control" name="message" id="message" placeholder="{{__('contact-placeholder-message')}}"
                              style="height: 12rem;">{{ request('part_name') ? 'Regarding ' . request('part_name') . ', Currus Connect ID: ' . request('article_nr') : '' }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-large w-100">{{__('contact-form-submit')}}</button>
            </form>
        </div>
    </div>
@endsection

@push('css')
<style>
    body {
        background-color: white !important; 
        background-image: none !important; 
    }

    @media (max-width: 767.98px) {
        .container.pt-5 {
            padding-top: 1rem;
        }
    }
</style>
@endpush
