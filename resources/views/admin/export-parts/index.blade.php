@extends('app')
@section('title', 'Admin - Fenix Parrts')
@section('content')
    <div class="container">
        <h1 class="p-4">Fenix car parts</h1>
        <div class="col-6 p-4">
            <p><span class="fw-bold">Count: </span> {{ $carParts->total() }}</p>
            <form action="{{ route('admin.export-parts.index') }}">
                <input type="hidden" name="dismantle_company" value="{{ request()->get('dismantle_company') }}">

                <div class="mb-2">
                    <label for="search" class="form-label">Search(part name, kba, car name, engine code)</label>
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ request()->get('search') }}">
                </div>
                <button class="btn btn-primary w-100 btn-large">Search</button>
            </form>

            <form action="{{ route('admin.export-parts.index') }}" class="pt-4">
                <div class="mb-2">
                    <label for="dismantle_company" class="form-label">Dismantle Company</label>
                        <select id="dismantle_company" name="dismantle_company" class="form-select">
                            <option value="all">All</option>

                            @foreach($uniqueDismantleCompanyCodes as $code)
                                <option @if (request()->get('dismantle_company') === $code) selected @endif value="{{ $code }}">{{ $code }}</option>
                            @endforeach
                        </select>
                </div>
                <button class="btn btn-primary w-100 btn-large">Search</button>
            </form>

            <form action="{{ route('admin.export-parts.index') }}" class="pt-4">
                <div class="mb-2">
                    <label for="part_type" class="form-label">Part type</label>
                    <select id="part_type" name="part_type" class="form-select">
                        <option value="all">All</option>

                        @foreach($partTypes as $type)
                            <option @if (request()->get('part_type') === (string)$type->id) selected @endif value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary w-100 btn-large">Search</button>
            </form>
        </div>
        <div class="d-flex flex-wrap">
            @foreach($carParts as $carPart)
                <div class="col-6 p-4">
                    <div class="card">
                        <div class="card-header">
                            {{ $carPart->new_name ?? $carPart->name }}
                        </div>
                        <div class="card-body">
                            <p><span class="fw-bold">#: </span> {{ $carPart->id}}</p>
                            <p><span class="fw-bold">Article number: </span> {{ $carPart->article_nr }}</p>
                            <p><span class="fw-bold">Original number: </span> {{ $carPart->original_number }}</p>
                            <p><span class="fw-bold">Price(SEK): </span> {{ $carPart->price_sek }}</p>
                            <p><span class="fw-bold">Price(DKK): </span> {{ $carPart->price_dkk}}</p>
{{--                            <p><span class="fw-bold">[OLD]Price(EUR): </span> €{{ $carPart->calculated_price }}</p>--}}
                            <p><span class="fw-bold">Total(EUR): </span> €{{ $carPart->new_price + $carPart->shipment }}</p>
                            <p><span class="fw-bold">[NEW]Price(EUR): </span> €{{ $carPart->new_price }}</p>
                            <p><span class="fw-bold">[B2B]Price(EUR): </span> €{{ $carPart->business_price }}</p>
                            <p><span class="fw-bold">Shipment(EUR): </span> €{{ $carPart->shipment }}</p>
                            <p><span class="fw-bold">Engine code: </span> {{ $carPart->engine_code }}</p>
                            <p><span class="fw-bold">Engine type: </span> {{ $carPart->engine_type }}</p>
                            <p><span class="fw-bold">Fuel: </span> {{ $carPart->fuel }}</p>
                            <p><span class="fw-bold">Gearbox: </span> {{ $carPart->subgroup ?? $carPart->gearbox }}</p>
                            <p><span class="fw-bold">Mileage(KM): </span> {{ $carPart->mileage_km }}</p>
                            <p><span class="fw-bold">Vin: </span> {{ $carPart->vin }}</p>
                            <p><span class="fw-bold">Model year: </span> {{ $carPart->model_year }}</p>
                            <p><span class="fw-bold">SBR PART CODE: </span> {{ $carPart->sbr_part_code }}</p>
                            <p><span class="fw-bold">SBR CAR CODE: </span> {{ $carPart->sbr_car_code }}</p>
                            <p><span class="fw-bold">Kbas: </span> {{ $carPart->kba_string }}</p>
                            <a href="{{ route('admin.export-parts.show', $carPart) }}" class="btn btn-primary w-100">View
                                part</a>
                            <img class="card-img-bottom mt-2"
                                 src="{{ isset( $carPart->carPartImages[0])  ? $carPart->carPartImages[0]->original_url: '' }}" />
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {{ $carParts->links() }}
        </div>
    </div>
@endsection
