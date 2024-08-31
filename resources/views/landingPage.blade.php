@extends('app')
@section('content')

<div class="cta">
    <div class="d-flex justify-content-center text-center mx-auto">
        @php
            $locale = App::getLocale();
            $logoPath = config("logos.{$locale}");
        @endphp
        <img src="{{ asset($logoPath) }}" style="max-width: 30rem; max-height: 50rem;" class="pt-4" alt="logo img" srcset="">
    </div>

    <div class="d-flex justify-content-center align-items-center mt-3">
        <div class="text-center">
            <a href="/car-parts/search/by-name?search=" class="fw-semibold btn btn-success">{{ __('browse')}}</a>
        </div>
    </div>

    <livewire:search-forms />
</div>

@endsection

