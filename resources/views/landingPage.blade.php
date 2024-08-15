@extends('app')
@section('content')

    <div class="text-center pt-2 mx-auto">
        <img src="logo/currus.png" alt="" srcset="">
        <h1 class="display-1 fw-bold d-inline-block position-relative underline-text">
            <span class="text-success">CURR</span><span class="text-white">US</span>
        </h1>
        <h2 class="display-4 fw-bold text-white">CAR PARTS</h2>
    </div>

    <div class="d-flex justify-content-center align-items-center mt-4">
        <div class="text-center">
            <a href="/" class="fw-semibold btn btn-success">BROWSE ALL</a>
        </div>
    </div>

    <!-- Search Functionality Section -->
    <div class="d-flex justify-content-center align-items-center mt-4">
        <div class="text-center">
            <a href="#" class="fw-semibold btn btn-success me-3">SEARCH BY HSN + TSN</a>
            <a href="#" class="fw-semibold btn btn-success me-3">SEARCH BY CAR MODEL</a>
            <a href="#" class="fw-semibold btn btn-success me-3">SEARCH BY OEM</a>
        </div>
    </div>

    <div class="cta d-flex justify-content-center gap-3 mt-3">
        <div class="card col-3 mb-3" style="z-index:5; height: 34rem;">
            <div class="card-header">
                <h3>Search by HSN + TSN</h3>
            </div>
            <div class="card-body">
                <p>
                    Search for a specific car if you know the HSN and TSN. This is the most accurate and fastest way to
                    find car parts for your car.
                </p>
                <livewire:kba-search :partTypes="$partTypes"/>
            </div>
        </div>

        <div class="card col-3 mb-3" style="z-index:5; height: 34rem;">
            <div class="card-header">
                <h3>Search by car model</h3>
            </div>
            <div class="card-body">
                @error('error')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
                @enderror
                @error('error2')
                <div class="alert alert-danger">
                    If you think this is a mistake please
                    <a target="_blank" href="{{ route('contact') }}">contact us.</a>
                </div>
                @enderror

                @error('error3')
                <div class="alert alert-danger">
                    If you are sure the HSN + TSN is correct please
                    <a target="_blank" href="{{ route('contact') }}">contact us.</a>
                </div>
                @enderror
                <p>
                    If you don't know the HSN and TSN or you want a more open search you can search by car model.
                </p>
                <livewire:model-search/>
            </div>
        </div>

        <div class="card col-3 mb-3" style="z-index:5; height: 34rem;">
            <div class="card-header">Search by OEM</div>
            <div class="card-body">
                <p>
                    Very detailed search that you can use if you have the original spare part number(OEM), gearbox code or engine code.
                </p>

                <livewire:oem-search></livewire:oem-search>
            </div>
        </div>
    </div>

@endsection
