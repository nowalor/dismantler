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
                    </div>
                @endif
                <form action="{{ route('newsletter.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('newsletter.newsletter_email') }}*</label>
                        <input required type="email" name="email" class="form-control"
                               placeholder="{{ __('newsletter.newsletter_email') }}" >
                        <div class="form-text">{{ __('newsletter.newsletter_well_never_share') }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="mb-3 form-check">
                            <input  required type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">{{ __('newsletter.newsletter_i_agree_to_') }}</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary w-100">{{ __('newsletter.newsletter_submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
@endsection
