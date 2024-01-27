@extends('app')
@section('title', 'Admin - Fenix Parts')
@section('content')
    <div class="container pt-4">
        <h3>
            {{ $carPart->name }}
        </h3>
        <div class="row">
            <div class="col-6 pt-4">
                <div class="card">
                    <div class="card-header">
                        Part information
                    </div>
                    <div class="card-body">
                        <p><span class="fw-bold">ID#: </span> {{ $carPart->id}}</p>
                        <p><span class="fw-bold">Article number: </span> {{ $carPart->article_nr }}</p>
                        <p><span class="fw-bold">Original number: </span> {{ $carPart->original_number }}</p>
                        <p><span class="fw-bold">Price(EUR): </span> €{{ $carPart->price }}</p>
                        <p><span class="fw-bold">Engine code: </span> {{ $carPart->engine_code }}</p>
                        <p><span class="fw-bold">Engine type: </span> {{ $carPart->engine_type }}</p>
                        <p><span class="fw-bold">Full engine code: </span> {{ $carPart->full_engine_code }}</p>
                        <p><span class="fw-bold">Fuel: </span> {{ $carPart->fuel }}</p>
                        <p><span class="fw-bold">Gearbox: </span> {{ $carPart->gearbox }}</p>
                        <p><span class="fw-bold">Mileage(KM): </span> {{ $carPart->mileage_km }}</p>
                        <p><span class="fw-bold">Vin: </span> {{ $carPart->vin }}</p>
                        <p><span class="fw-bold">Model year: </span> {{ $carPart->model_year }}</p>
                        <p><span class="fw-bold">SBR PART CODE: </span> {{ $carPart->sbr_part_code }}</p>
                        <p><span class="fw-bold">SBR CAR CODE: </span> {{ $carPart->sbr_car_code }}</p>
                        <p><span class="fw-bold">Kbas: </span> {{ $carPart->kba_string }}</p>
                        <p><span class="fw-bold">All Kbas:</span></p>
                        <ol>
                            @foreach($carPart->unique_kba as $kba)
                                <li>
                                    <span class="fw-bold">{{ $kba->hsn . $kba->tsn }}</span>
                                    <ul>
                                        @foreach($kba->engineTypes as $engineType)
                                            <li>{{ $engineType->name }}</li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-6 d-flex flex-wrap">
                @foreach($carPart->carPartImages as $carPartImage)
                    <div class="col-6">
                        <img class="card-img-bottom"
                             src=" {{ $carPartImage->original_url }}"
                             alt="">

                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
