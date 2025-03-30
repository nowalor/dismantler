@extends('app')

@section('content')
    <div class="container mx-auto pt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href=" {{ route('landingpage') }} ">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Car parts</li>
            </ol>
        </nav>
        <div class="col-6">
            <h1>Find your spare part today! <i class="fa fa-solid fa-car"></i></h1>
            <p>We currently have 12364231 parts available so hopefully you are able to find what you are looking
                for!</p>
        </div>
        <div class="row">
            @if($ditoNumber)
                <div class="col-6 mb-3">
                    <div class="card">
                        <h5 class="card-header">
                            Showing parts for
                        </h5>
                        <div class="card-body">
                            <h3>{{ "$ditoNumber->producer $ditoNumber->brand"}}</h3>
                            <p>Based on the combination of your HSN + TSN we detected this is your car</p>
                            <p>If it's not correct please <a href="{{ route('contact') }}" class="link-info">Contact us</a> and we will fix it</p>
                            <div class="display-flex">
                                <p>
                                    <span class="fw-bold">Producer:</span>
                                    {{ $ditoNumber->producer }}
                                </p>
                                <p>
                                    <span class="fw-bold">Brand</span>
                                    {{ $ditoNumber->brand }}
                                </p>
                                <p>
                                    <span class="fw-bold">Parts for this car: </span>
                                    {{ $parts->total() }}
                                </p>
                                <p>
                                    <span class="fw-bold">Parts with same engine type for different cars: </span>
                                    {{ $partsDifferentCarSameEngineType->total() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-6 mb-3">
                <div class="card">
                    <h5 class="card-header">Filters</h5>
                    <div class="card-body">
                        {{-- this route no longer exists --}}
                        {{-- <form action="{{ route('car-parts.index') }}">
                            <div>
                                <div>
                                    <label for="brand">Car model</label>
                                    <select class="form-control" id="brand">
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                    @if($brand->name === request()->get('brand')) selected
                                                    @elseif(empty(request()->get('brand')) && $ditoNumber && $ditoNumber->producer === $brand->name) selected @endif >
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex gap-2 mb-1">
                                    <div>
                                        <label>HSN</label>
                                        <input value="{{ request()->get('hsn') }}" class="form-control" type="text">
                                    </div>
                                    <div>
                                        <label>TSN</label>
                                        <input value="{{ request()->get('tsn') }}" class="form-control" type="text">
                                    </div>
                                </div>
                                <div>
                                    <div>
                                        <label>Advanced search</label>
                                        <input value="{{ request()->get('advanced_search') }}" class="form-control"
                                               type="text">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Search by</label>
                                    <div class="d-flex gap-2">
                                        <div>
                                            <input class="form-check-input" type="radio" name="search_by"
                                                   value="everything"
                                                   @if(request()->get('search_by') === 'everything') checked @endif>

                                            <label class="form-check-label">
                                                Everything
                                            </label>
                                        </div>
                                        <div>
                                            <input class="form-check-input" type="radio" name="search_by"
                                                   value="engine_type"
                                                   @if(request()->get('search_by') === 'engine_type') checked @endif
                                            >
                                            <label class="form-check-label">
                                                Engine type
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary mt-3">Search</button>
                            <a href="{{ route('car-parts.index') }}" class="btn btn-warning text-white mt-3">Clear
                                filters</a>
                        </form> --}}
                    </div>
                </div>
            </div>
        </div>


        <div>
            @if($parts && $parts->total())
                <div>
                    <h2>Parts</h2>
                    <div class="col-12 d-flex flex-wrap">
                        @foreach($parts as $part)
                            <div class="col-4">
                                <div class="card m-3">
                                    <p class="card-header">{{ $part->name }}</p>
                                    <img style="height:300px;" class="card-img-top shadow-sm"
                                         src="{{ count($part->carPartImages) ? $part->carPartImages[0]->origin_url : asset('no-image-placeholder.jpg')}}"
                                         alt="Card image cap">
                                    <div class="card-body">

                                        <p>
                                            <span
                                                class="fw-bold">Name:</span> {{ $part->name }}
                                        </p>
                                        <p>
                                            <span class="fw-bold">Part type:</span> {{ $part->carPartType?->name }}
                                        </p>
                                        <p>
                                    <span
                                        class="fw-bold">Price:</span> {{ $part->price1 > 0 ? $part->price1 : 'Contact us for price' }}
                                        </p>
                                        <p>
                                            <span class="fw-bold">Oem number:</span> {{ $part->oem_number }}
                                        </p>
                                        <p>
                                            <span
                                                class="fw-bold">Producer:</span> {{ $part->ditoNumber->producer ?? 'Information missing' }}
                                        </p>
                                        <p>
                                            <span class="fw-bold">Brand:</span> {{ $part->ditoNumber->brand ?? 'Information missing'}}
                                        </p>

                                        {{-- Route no longer exists --}}
                                        {{-- <a href="{{ route('car-parts.show', $part) }}"
                                           class="btn btn-primary w-100 mt-3">View
                                            part</a> --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $parts->withQueryString()->links() }}
                </div>
            @endif
        </div>
        @if($partsDifferentCarSameEngineType && $partsDifferentCarSameEngineType->total())
            <div>
                <h2>Parts from other cars</h2>
                <p class="leading">These are parts from other cars but with the same engine type. They might fit your
                    car. If you are
                    unsure you can <a class="link-primary" href="{{ route('contact') }}">Contact us</a>
                </p>
                <div class="card">
                    <div class="col-12 d-flex flex-wrap">
                        @foreach($partsDifferentCarSameEngineType as $part)
                            <div class="col-3">
                                <div class="card m-3">
                                    <p class="card-header" style="font-size:13px;">{{ $part->name }}</p>
                                    <img style="height:200px;" class="card-img-top shadow-sm"
                                         src="{{ count($part->carPartImages) ? $part->carPartImages[0]->origin_url : asset('no-image-placeholder.jpg')}}"
                                         alt="Card image cap">
                                    <div class="card-body">

                                        <p style="font-size: 12px;">
                                            <span class="fw-bold">Part type:</span> {{ $part->carPartType->name }}
                                        </p>
                                        <p style="font-size: 12px;">
                                            <span class="fw-bold">Price:</span> {{ $part->price1 }}
                                        </p>
                                        <p style="font-size: 12px;">
                                            <span
                                                class="fw-bold">Transmission type:</span> {{ $part->transmission_type}}
                                        </p>
                                        <p style="font-size: 12px;">
                                            <span class="fw-bold">Condition:</span> {{ $part->condition }}
                                        </p>

                                        {{-- route no longer exists --}}
                                        {{-- <a href="{{ route('car-parts.show', $part) }}"
                                           class="btn btn-primary w-100 mt-3">View
                                            part</a> --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $partsDifferentCarSameEngineType->withQueryString()->links() }}

                </div>
            </div>
        @endif
        @if(
            (!$parts || !$parts->total()) &&
            (!$partsDifferentCarSameEngineType || !$partsDifferentCarSameEngineType->total())
        )
            <div>
                We did not find any parts for your car.
            </div>
        @endif
    </div>
@endsection

