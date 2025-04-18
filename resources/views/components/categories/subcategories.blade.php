@extends('app')
@section('title', 'Currus-connect.com: ' . __("main-categories.$mainCategory->translation_key"))
@section('content')

    <div class="container my-4 pt-4 bg-white rounded shadow">
        <h1 class="text-center text-primary mb-4">{{ __("main-categories.$mainCategory->translation_key") }}</h1>
        <div class="row justify-content-center">
            @foreach ($mainCategory->carPartTypes as $subCategory)
            @if ($subCategory->slug)
                <div class="col-md-4 mb-4 d-flex justify-content-center">
                    <div class="p-3 border rounded bg-light text-center shadow-sm w-100" style="max-width: 300px;">
                        <a href="{{ route('subcategories.brands', ["subCategory" => $subCategory->slug]) }}" class="text-dark text-decoration-none">
                            <h5 class="mb-0">{{ __("car-part-types.$subCategory->translation_key") }}</h5>
                        </a>
                    </div>
                </div>
                @endif
             @endforeach

        </div>
    </div>

@endsection
