@extends('app')


@section('content')
    <div class="cta d-flex justify-content-center gap-3">
        <div class="card col-3 mb-3" style="z-index:5; top:20vh; height: 34rem;">
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
        <div class="card col-3" style="z-index:5; top:20vh; height: 34rem;">
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

        <div class="card col-3" style="z-index:5; top:20vh; height: 34rem;">
            <div class="card-header">Search by OEM</div>
            <div class="card-body">
                <p>
                    Very detailed search that you can use if you have the original spare part number(OEM), gearbox code or engine code.
                </p>

                <livewire:oem-search></livewire:oem-search>
            </div>
        </div>

    </div>
    <div class="container pt-3">
        <h1 class="text-center pt-3">
            Benefits of buying from us
        </h1>
        <p class="text-center pb-3" style="width: 50vw;">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad autem eligendi facilis fugit, iure nesciunt
            nihil non obcaecati, quia quo ratione rem sequi unde vel veniam. Culpa ex mollitia quod.
        </p>
        <div class="row pt-3">
            <div class="col-4">
                <h6>Reason one</h6>
                <img style="height: 400px; width: 100%;" src="{{ asset('img/car-banner2.jpg') }}" alt="">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere fuga itaque molestias provident
                    quibusdam? Cumque dolore dolorum esse illum molestias necessitatibus nobis. Aspernatur beatae dolor
                    exercitationem praesentium saepe? Doloremque, laborum?</p>
            </div>

            <div class="col-4">
                <h6>Reason one</h6>
                <img style="height: 400px; width: 100%;" src="{{ asset('img/car-banner2.jpg') }}" alt="">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere fuga itaque molestias provident
                    quibusdam? Cumque dolore dolorum esse illum molestias necessitatibus nobis. Aspernatur beatae dolor
                    exercitationem praesentium saepe? Doloremque, laborum?</p>
            </div>

            <div class="col-4">
                <h6>Reason one</h6>
                <img style="height: 400px; width: 100%;" src="{{ asset('img/car-banner2.jpg') }}" alt="">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere fuga itaque molestias provident
                    quibusdam? Cumque dolore dolorum esse illum molestias necessitatibus nobis. Aspernatur beatae dolor
                    exercitationem praesentium saepe? Doloremque, laborum?</p>
            </div>

        </div>

        <div class="row pt-3 pb-3">
            <div class="row g-2">
                <div class="col-12">
                    <img style="width: 100%;" src="{{ asset('img/homepage-gallery/img-1.jpg') }}" alt="">
                </div>
                <div class="col-6">
                    <img style="width: 100%;" src="{{ asset('img/homepage-gallery/img-2.jpg') }}" alt="">
                </div>
                <div class="col-6">
                    <img style="width: 100%;" src="{{ asset('img/homepage-gallery/img-3.jpg') }}" alt="">
                </div>
            </div>
        </div>


        <h1 class="text-center pt-3">
            Brands
        </h1>
        <p class="text-center">
            We currently have parts from <span class="fw-bold">{{ $brands->count() }}</span> brands available. We are
            only showing brands on here where we currenty have at least one part in the system
        </p>
        <div class="row g-2">
            @foreach($brands as $brand)
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $brand->name }}</h5>
                            <p class="card-text pb-2">We currently have <span
                                    class="fw-bold">{{ $brand->car_parts_count }}</span> parts available for
                                this {{ $brand->name }}</p>
                            <img class="mb-2" style="width:50%;" src="{{ asset('img/car-brand-logos/audi-logo.png') }}"
                                 alt="">
                            <a href="#" class="btn btn-primary w-100 d-block mt-2">View parts for {{ $brand->name }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection('content')
