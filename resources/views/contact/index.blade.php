{{-- @extends('app')
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
                    <input required type="text" class="form-control" name="subject" id="email" placeholder="{{__('contact-placeholder-subject')}}">
                </div>
                <div class="mb-2">
                    <label for="email">{{__('contact-form-email')}}</label>
                    <input required type="email" class="form-control" name="email" id="email" placeholder="{{__('contact-placeholder-email')}}">
                </div>
                <div class="mb-2">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone">
                </div>
                @if(app()->getLocale() === 'dk')
                <div class="mb-2">
                    <label for="plate">Nummerplade</label>
                    <input type="text" class="form-control" name="plate" id="plate" placeholder="Nummerplade">
                </div>
                @endif
                @if(app()->getLocale() === 'ge')
                    <div class="mb-2">
                        <label for="vin">Fahrgestellnummer</label>
                        <input type="text" class="form-control" name="vin" id="vin" placeholder="Fahrgestellnummer">
                    </div>
                @endif
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
@endpush --}}

@extends('app')
@section('content')
    <!-- Banner Section with Image -->
    <div class="position-relative text-center mb-5">
        <img src="{{ asset('img/car-banner2.jpg') }}" alt="Car Banner" class="img-fluid w-100" style="height: 400px; object-fit: cover; filter: brightness(80%);">
        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center" style="background-color: rgba(0, 0, 0, 0.3);">
            <h1 class="display-5 text-white fw-bold">{{ __('contact-us') }}</h1>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container pt-4">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center bg-light p-3 rounded-3 shadow-sm">
                <li class="breadcrumb-item">
                    <a href="{{ route('landingpage') }}" class="text-decoration-none text-success">{{ __('home') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('contact-us') }}</li>
            </ol>
        </nav>

        <!-- Intro Text -->
        <div class="text-center mt-4 mb-4">
            <p class="lead text-muted" style="font-size: 1.25rem;">{{ __('contact-asap') }}</p>
            <p class="fw-light text-muted">{{ __('contact-before') }} <a href="{{ route('faq') }}" class="link-success fw-bold">{{ __('FAQ') }}</a></p>
        </div>

        <!-- Contact Form -->
        <div class="col-12 col-md-8 mx-auto pt-3">
            <form action="{{ route('contact.send') }}" method="POST" class="p-4 bg-light rounded-3 shadow-lg">
                @csrf
                @if(session()->has('message'))
                    <div class="alert alert-success">{{ session()->get('message') }}</div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger">{{ session()->get('error') }}</div>
                @endif

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('contact-form-name') }}</label>
                    <input required type="text" class="form-control" name="name" id="name" placeholder="{{ __('contact-placeholder-name') }}">
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label">{{ __('contact-form-subject') }}</label>
                    <input required type="text" class="form-control" name="subject" id="subject" placeholder="{{ __('contact-placeholder-subject') }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('contact-form-email') }}</label>
                    <input required type="email" class="form-control" name="email" id="email" placeholder="{{ __('contact-placeholder-email') }}">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">{{ __('contact-form-phone') }}</label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="{{ __('contact-placeholder-phone') }}">
                </div>

                @if(app()->getLocale() === 'dk')
                    <div class="mb-3">
                        <label for="plate" class="form-label">Nummerplade</label>
                        <input type="text" class="form-control" name="plate" id="plate" placeholder="Nummerplade">
                    </div>
                @endif

                @if(app()->getLocale() === 'ge')
                    <div class="mb-3">
                        <label for="vin" class="form-label">Fahrgestellnummer</label>
                        <input type="text" class="form-control" name="vin" id="vin" placeholder="Fahrgestellnummer">
                    </div>
                @endif

                <div class="mb-4">
                    <label for="message" class="form-label">{{ __('contact-form-message') }}</label>
                    <textarea required class="form-control" name="message" id="message" placeholder="{{ __('contact-placeholder-message') }}" style="height: 12rem; resize: none;">{{ request('part_name') ? 'Regarding ' . request('part_name') . ', Currus Connect ID: ' . request('article_nr') : '' }}</textarea>
                </div>
                <button type="submit" class="btn btn-success w-100">{{ __('contact-form-submit') }}</button>
            </form>
        </div>
    </div>

@endsection

@push('css')
<style>
    body {
        background-color: #dce0e6 !important;
        background-image: none !important;
        padding-bottom: 2rem;
    }
    .breadcrumb, .form-control, .alert {
        border-radius: 0.375rem;
    }
    .form-control, .breadcrumb, .btn-success {
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }
    .btn-success:hover {
        background-color: #28a745 !important;
        box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
    }
    .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
    }
</style>
@endpush

