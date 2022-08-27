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
                            <span class="fw-bold">Dismantle company:</span> {{ $carPart->dismantleCompany->full_name }}
                        </p>
                        <p>
                            <span class="fw-bold">Part type:</span> {{ $carPart->carPartType->name }}
                        </p>
                        <p>
                            <span class="fw-bold">Price:</span> {{ $carPart->price1 }}
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
                            <span class="fw-bold">Notes:</span> {{ $carPart->notes }}
                        </p>

                        <p>
                            <span class="fw-bold">Kilo watt:</span> {{ $carPart->kilo_watt }}
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
