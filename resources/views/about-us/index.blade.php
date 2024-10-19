@extends("app")
@section("content")

<div class="container my-5">
    <div class="text-center">
        <h1 class="display-4 text-success">{{__('about-header')}}</h1>
        <p class="lead text-muted">{{__('about-intro')}}</p>
    </div>
    <div class="container my-4 text-center" style="max-width: 65%;">
        <p class="mt-4 font-italic text-center">
            {{__('about-text-one')}} <strong>{{__('currus-connect')}}</strong> {{__('about-text-two')}}
        </p>
        <h5 class="mt-2 font-italic text-center">
            {{__('about-text-three')}}
        </h5>
        <h5 class="mt-2 font-italic text-center">
            {{__('about-text-four')}}
        </h5>
        <h5 class="mt-2 font-italic text-center">
            {{__('about-text-five')}}
        </h5>
        <h5 class="mt-2 font-italic text-center">
            {{__('about-text-six')}}
        </h5>
        <h5 class="mt-4 font-italic text-center">
            {{__('about-text-seven')}}
        </h5>
    </div>
</div>

@endsection

@push('css')
<style>
    body {
        background-color: white !important; 
        background-image: none !important; 
    }
</style>
@endpush