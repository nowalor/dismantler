@extends('app')
@section('content')

<div class="cta">
    <div class="d-flex justify-content-center text-center mx-auto pt-4">
        <img src="{{ asset($logoPath) }}" style="max-width: 25rem; max-height: 40rem;" class="pt-2" alt="logo img" srcset="">
    </div>

    <div class="d-flex justify-content-center align-items-center mt-3">
        <div class="text-center">
          {{--  <a href="/car-parts/search/by-name?search=" class="fw-semibold btn btn-success">{{ __('browse')}}</a>--}}
        </div>
    </div>

    <livewire:search-forms />
</div>

@endsection


