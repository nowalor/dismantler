@extends('app')
@section('title', 'Admin - Information page')

@section('content')
    <div class="container pt-2">
        <h3>Car parts for dito number {{ $ditoNumber }}</h3>
        <div class="row pt-2">
            @foreach($carParts as $carPart)
                <div class="col-6 mb-2">
                    <div class="card">
                        <div class="card-header">
                            {{ $carPart->name }}
                        </div>
                        <div class="card-body">
                            <p>
                                <span class="fw-bold">Transmission type:</span> {{ $carPart->transmission_type}}
                            </p>

                            <p>
                                <span class="fw-bold">Engine Code:</span> {{ $carPart->engine_code }}
                            </p>

                            <p>
                                <span class="fw-bold">Engine type:</span> {{ $carPart->engine_type }}
                            </p>

                            <a href="{{ route('admin.car-parts.show', $carPart) }}"
                               class="btn btn-primary w-100 mb-2">View</a>
                        </div>
                        
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
