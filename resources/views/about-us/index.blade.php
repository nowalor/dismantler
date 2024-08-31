@extends("app")
@section("content")

<div class="container my-5">
    <div class="text-center">
        <h1 class="display-4 text-success">{{__('about-header')}}</h1>
        <p class="lead text-muted">{{__('about-intro')}}</p>
    </div>
        <p class="mt-4 font-italic text-center">
            {{__('about-text-one')}} <strong>{{__('currus-connect')}}</strong> {{__('about-text-two')}}
        </p>
    </div>
</div>

@endsection
