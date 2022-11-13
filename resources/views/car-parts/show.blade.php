@extends('app')
@section('title', 'Single car part')
@section('content')
    <div class="container mx-auto">
        <div class="row pt-4">
            <div class="col-6">
                <h3 class="pt-4">{{ $carPart->name }}</h3>
                <img style="max-height: 500px;" class="w-100" src="{{
    !empty($carPart->carPartImages[0]) ? $carPart->carPartImages[0]?->origin_url :
    asset('no-image-placeholder.jpg')
    }}" alt="">
                @foreach($carPart->carPartImages as $image)
                    <img src="{{ $image->thumbnail_url }}" alt=""/>
                @endforeach
            </div>
            <div class="col-6">
                <div class="card">
                    <h5 class="card-header">
                        Part information
                    </h5>
                    <div class="card-body">

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
                            <span class="fw-bold">Engine type:</span> {{ $carPart->engine_type}}
                        </p>


                    </div>
                </div>
                @if($carPart->price1 > 0)
                    <div class="pt-2">
                        <h3>Buy now with</h3>
                        <div class="d-flex gap-2">
                            <form action="{{ route('checkout', $carPart) }}">
                                @csrf
                                <!-- <button class="btn btn-primary" style="background-color: #FFC439; border: none;">
                                <img src="{{ asset('img/paypal-logo.png') }}" style="height: 24px;" alt="Paypal Logo">
                            </button> -->
                                <button class="btn btn-primary">
                                    Buy now
                                </button>
                            </form>

                            <!-- <button class="btn btn-primary">Invoice 📄</button> -->
                        </div>
                    </div>
                @else
                    <div class="pt-2">
                        <h3>This part does not have a price yet</h3>
                        <p>If you are interested in this part you can <a href="{{ route('contact') }}">contact us</a>
                            about the price </p>
                        <a href="{{ route('contact') }}" class="btn btn-primary">Contact us</a>
                    </div>
                @endif
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
@endsection()
