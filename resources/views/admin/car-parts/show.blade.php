@extends('app')
@section('title', 'Car part - ' . $carPart->name)

@section('content')
    <div class="container mx-auto">
        <h3 class="pt-4">{{ $carPart->name }}</h3>
        <div class="row">
            <div class="col-6 pt-4">
                <img style="max-height: 500px;" class="w-100" src="{{ $carPart->carPartImages[0]->origin_url }}" alt="">
                @foreach($carPart->carPartImages as $image)
                    <img src="{{ $image->thumbnail_url }}" alt=""/>
                @endforeach
            </div>

            <div class="col-6 pt-4">
                <div class="card">
                    <h5 class="card-header">
                        Part information
                    </h5>
                    <div class="card-body">
                        <p>
                            <span class="fw-bold">Id:</span> {{ $carPart->identifer }}
                        </p>

                        <p>
                            <span class="fw-bold">Dismantle company:</span> {{ $carPart->dismantleCompany->full_name }}
                        </p>
                        <p>
                            <span class="fw-bold">Part type:</span> {{ $carPart->carPartType->name }}
                        </p>
                        <p>
                            <span class="fw-bold">Price:</span> {{ $carPart->price }}
                        </p>
                        <p>
                            <span class="fw-bold">Quantity:</span> {{ $carPart->quantity }}
                        </p>
                        <p>
                            <span class="fw-bold">Transmission type:</span> {{ $carPart->transmission_type}}
                        </p>
                        <p>
                            <span class="fw-bold">Condition:</span> {{ $carPart->condition }}
                        </p>

                        <p>
                            <span class="fw-bold">Comments:</span> {{ $carPart->comments }}
                        </p>

                        <p>
                            <span class="fw-bold">Kilo watt:</span> {{ $carPart->km }}
                        </p>

                        <p>
                            <span class="fw-bold">Oem number:</span> {{ $carPart->oem_number }}
                        </p>

                        <p>
                            <span class="fw-bold">Shelf number:</span> {{ $carPart->shelf_number }}
                        </p>

                        <p>
                            <span class="fw-bold">Color:</span> {{ $carPart->color}}
                        </p>

                        <p>
                            <span class="fw-bold">Vin number:</span> {{ $carPart->vin_number}}
                        </p>

                        <p>
                            <span class="fw-bold">Engine code:</span> {{ $carPart->engine_code}}
                        </p>

                        <p>
                            <span class="fw-bold">Engine type:</span> {{ $carPart->engine_type}}
                        </p>


                    </div>
                </div>
            </div>
        </div>

        <div class="row pt-4 pb-4">
            <div class="col-6">
                <div class="card">
                    <h3 class="card-header">Notes</h3>
                    <div class="card-body">
                        <div style=" white-space: pre-wrap;">{{ $carPart->notes }}</div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <h3 class="card-header">Comments</h3>
                    <div class="card-body">
                        <div style=" white-space: pre-wrap;">{{ $carPart->comments }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
