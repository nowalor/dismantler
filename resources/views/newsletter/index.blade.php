@extends('app')

@section('title', 'Sign up for newsletter')

@section('content')
    <div class="container d-flex justify-content-center pt-4">
        <div class="col-6">
            <div class="card">
                <div class="card-header">{{ __('newsletter.newsletter_sign_up') }}</div>
                <div class="card-body">
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ __('newsletter.newsletter_thank_you_for_signing_up') }}
                            <a href="{{ route('landingpage') }}"> {{ __('newsletter.newsletter_go_back_to_homepage') }}</a>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-info">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="newsletter-form" action="{{ route('newsletter.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('newsletter.newsletter_name') }}</label>
                            <input id="name" type="text" name="name" class="form-control"
                                placeholder="{{ __('newsletter.newsletter_name') }}">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('newsletter.newsletter_email') }}*</label>
                            <input id="email" required type="email" name="email" class="form-control"
                                placeholder="{{ __('newsletter.newsletter_email') }}">
                            <div class="form-text">{{ __('newsletter.newsletter_well_never_share') }}</div>
                        </div>

                        <div class="mb-3 form-check">
                            <input required type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label"
                                for="exampleCheck1">{{ __('newsletter.newsletter_i_agree_to_') }}</label>
                        </div>

                        <input type="hidden" name="recaptcha_token" id="recaptcha_token">

                        @if ($errors->has('recaptcha_token'))
                            <div class="alert alert-danger mb-3">
                                {{ $errors->first('recaptcha_token') }}
                            </div>
                        @endif

                        <button class="btn btn-success w-100">{{ __('newsletter.newsletter_submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://www.google.com/recaptcha/api.js?render={{ config('recaptcha.api_site_key') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('newsletter-form');
            const tokenField = document.getElementById('recaptcha_token');
            const siteKey = "{{ config('recaptcha.api_site_key') }}";

            if (!form || !tokenField || !siteKey) return;

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                grecaptcha.ready(function () {
                    grecaptcha.execute(siteKey, { action: 'newsletter' }).then(function (token) {
                        tokenField.value = token;
                        form.submit();
                    }).catch(function (error) {
                        console.error('reCAPTCHA error:', error);
                        alert('Google reCAPTCHA failed. Please try again.');
                    });
                });
            });
        });
    </script>
@endsection