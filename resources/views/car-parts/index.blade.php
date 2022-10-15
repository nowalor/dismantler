@extends('app')

@section('content')
    <div class="container mx-auto pt-4">
        <div class="col-12 mb-3">
            <div class="card">
                <h5 class="card-header">Filters</h5>
                <div class="card-body">
                    <form action="{{ route('admin.car-parts.index') }}">
                        <div>
                            <div class="d-flex gap-2 mb-1">
                                <div>
                                    <label>HSN</label>
                                    <input value="{{request()->get('hsn')}}" class="form-control" type="text">
                                </div>
                                <div>
                                    <label>TSN</label>
                                    <input value="{{request()->get('tsn')}}" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="d-flex gap-2 mb-1">
                                <div>
                                    <div>
                                        <label>Part type</label>
                                        <input value="{{ request()->input('part-type') }}" list="part-type-list"
                                               name="index-part-type" class="form-select">
                                        <datalist id="part-type-list">
                                            @foreach($partTypes as $partType)
                                                <option @if(request()->input('plaintext') == $partType->name) selected
                                                        @endif value="{{$partType->name }}">{{ $partType->name }}
                                                </option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                                <div>
                                    <label>Dismantle companies</label>
                                    <input value="{{ request()->input('dismantle-company') }}"
                                           list="dismantle-company-list"
                                           name="index-dismantle-company" class="form-select">
                                    <datalist id="dismantle-company-list">
                                        @foreach($dismantleCompanies as $dismantleCompany)
                                            <option
                                                @if(request()->input('plaintext') == $dismantleCompany->name) selected
                                                @endif value="{{ $dismantleCompany->name }}">{{ $dismantleCompany->name }}
                                            </option>
                                        @endforeach
                                    </datalist>
                                </div>

                            </div>
                            <div class="d-flex gap-2 mb-1">
                                <div>
                                    <label>Selected car model</label>
                                    <input class="form-control" type="text">
                                </div>
                                <div>
                                    <label>Advanced search</label>
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Search by</label>
                                <div class="d-flex gap-2">
                                    <div>
                                        <input class="form-check-input" type="radio" name="search_by" checked
                                               value="everything">
                                        <label class="form-check-label">
                                            Everything
                                        </label>
                                    </div>
                                    <div>
                                        <input class="form-check-input" type="radio" name="search_by"
                                               value="engine_type">
                                        <label class="form-check-label">
                                            Engine type
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary mt-3">Submit</button>
                        <a href="{{ route('admin.car-parts.index') }}" class="btn btn-warning text-white mt-3">Clear
                            filters</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 mb-3">
            @if($kba)
                <div class="card">
                    <h5 class="card-header">
                        {{ $kba->carName }}
                    </h5>
                    <div class="card-body">
                        <div class="display-flex">
                            <p>
                                <span class="fw-bold">HSN</span>
                                {{ $kba->hsn }}
                            </p>
                            <p>
                                <span class="fw-bold">TSN</span>
                                {{ $kba->tsn }}
                            </p>
                        </div>
                        <p>
                            <span class="fw-bold">Plaintext</span>
                            {{ $kba->manufacturer_plaintext }}
                        </p>
                        <p>
                            <span class="fw-bold">Commercial name</span>
                            {{ $kba->commercial_name }}
                        </p>
                    </div>
                </div>
            @endif
        </div>


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
                                    <span class="fw-bold">Dismantle company:</span> {{ $part->dismantleCompany->name }}
                                </p>
                                <p>
                                    <span class="fw-bold">Part type:</span> {{ $part->carPartType->name }}
                                </p>
                                <p>
                                    <span class="fw-bold">Price:</span> {{ $part->price1 }}
                                </p>
                                <p>
                                    <span class="fw-bold">Quantity:</span> {{ $part->quantity }}
                                </p>
                                <p>
                                    <span class="fw-bold">Transmission type:</span> {{ $part->transmission_type}}
                                </p>
                                <p>
                                    <span class="fw-bold">Condition:</span> {{ $part->condition }}
                                </p>

                                <a href="{{ route('car-parts.show', $part) }}" class="btn btn-primary w-100 mt-3">View
                                    part</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $parts->withQueryString()->links() }}
        </div>
        @if($partsDifferentCarSameEngineType)
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

                                        <a href="{{ route('car-parts.show', $part) }}"
                                           class="btn btn-primary w-100 mt-3">View
                                            part</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $partsDifferentCarSameEngineType->withQueryString()->links() }}

                </div>
            </div>
        @endif
    </div>
@endsection

