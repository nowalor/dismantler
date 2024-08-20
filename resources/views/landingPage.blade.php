@extends('app')
@section('content')

<div class="cta">
    <div class="text-center mx-auto">
        <img src="logo/currus.png" alt="" srcset="">
        <h1 class="display-1 fw-bold d-inline-block position-relative underline-text">
            <span class="text-success">CURR</span><span class="text-white">US</span>
        </h1>
        <h2 class="display-4 fw-bold text-white">{{ __('car-parts') }}</h2>
    </div>

    <div class="d-flex justify-content-center align-items-center mt-3">
        <div class="text-center">
            <a href="/car-parts/search/by-name?search=" class="fw-semibold btn btn-success">{{ __('browse')}}</a>
        </div>
    </div>

    <livewire:search-forms />
</div>

@endsection
