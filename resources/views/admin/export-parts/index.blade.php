@extends('app')
@section('title', 'Admin - Fenix Parrts')
@section('content')
    <div class="container">
        <div class="d-flex flex-wrap">
            @foreach($carParts as $carPart)
                <div class="col-6 p-4">
                    <div class="card">
                        <div class="card-header">
                            {{ $carPart->name }}
                        </div>
                        <div class="card-body">
                            <p> <span class="fw-bold">Article number: </span> {{ $carPart->article_nr }}</p>
                            <p> <span class="fw-bold">Original number: </span> {{ $carPart->original_number }}</p>
                            <p> <span class="fw-bold">Price(EUR): </span> €{{ $carPart->price }}</p>
                            <p> <span class="fw-bold">Engine code: </span> {{ $carPart->engine_code }}</p>
                            <p> <span class="fw-bold">Engine type: </span> {{ $carPart->engine_type }}</p>
                            <p> <span class="fw-bold">Fuel: </span> {{ $carPart->fuel }}</p>
                            <p> <span class="fw-bold">Gearbox: </span> {{ $carPart->gearbox }}</p>
                            <img class="card-img-bottom"
                                 src="{{ count($carPart->carPartImages) ? asset("storage/img/car-part/{$carPart->id}/{$carPart->carPartImages[0]->image_name}") : '' }}"
                                 alt="">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
