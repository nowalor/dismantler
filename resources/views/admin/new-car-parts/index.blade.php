@extends('app')
@section('title', 'Admin - Car parts without connection')
@section('content')
    <div class="container pt-2">
        <h3>Car parts</h3>
        <div class="card">
            <div class="card-header">
                Information
            </div>
            <div class="card-body">
                <h3 class="card-text">Hey Marcus</h3>
                <p class="card-text">Currently you have <span class="fw-bold">{{ $totalCarParts }}</span> total car
                    parts</p>
                <p class="card-text"><span class="fw-bold">{{ $totalCarPartsWithDitoNumber }}</span> Have a connection
                    to a dito number</p>
                <p class="card-text"><span class="fw-bold">{{ $totalCarPartsWithoutDitoNumber }}</span> Do not have a
                    connection to a dito number</p>
                <p class="card-text"><span class="fw-bold">{{ $totalCarPartsWithDitoNumberAndIsInteresting }} </span>have
                    a connection to a dito number and is marked as interesting</p>
                <p class="card-text"><span class="fw-bold">{{ $totalCarPartsWithKbaConnection }}</span> parts have a
                    connection to a kba through the dito number</p>
                <p class="card-text"><span class="fw-bold">{{ $totalCarPartsWithoutKbaConnection }}</span> parts are
                    missing a kba connection through the dito number</p>
            </div>
        </div>
        <div class="card col-10 mx-auto mb-4">
            <div class="card-header">Filters</div>
            <div class="card-body">
                <div class="d-flex gap-4">
                    <div>
                        <span class="d-block">Remove</span>
                        <a href="" class="btn btn-primary">Remove filter</a>
                    </div>
                    <div>
                        KBA status
                        <div class="flex">
                            <a href="{{ route('admin.new-parts', ['kba_filter' => 'with_kba']) }}"
                               class="btn btn-primary">
                                With KBA
                            </a>
                            <a href="{{ route('admin.new-parts', ['kba_filter' => 'without_kba']) }}"
                               class="btn btn-primary">
                                Without KBA
                            </a>
                        </div>
                    </div>
                    <div>
                        Completion
                        <div class="flex">
                            <a href="{{ route('admin.new-parts', ['completion_filter' => 'completed']) }}"
                               class="btn btn-primary">
                                Complete
                            </a>
                            <a href="{{ route('admin.new-parts', ['completion_filter' => 'uncompleted']) }}"
                               class="btn btn-primary">
                                Incomplete
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-4 justify-content-center">
            @foreach($carParts as $carPart)
                <div class="card mb-2 col-5">
                    <div class="card-header">
                        {{  $carPart->name }}
                    </div>
                    <div class="card-body">

                        <p>
                            <span class="fw-bold">Dismantle company:</span> {{ $carPart->dismantleCompany?->name }}
                        </p>
                        <p>
                            <span class="fw-bold">Part type:</span> {{ $carPart->carPartType->name }}
                        </p>
                        <p>
                            <span
                                class="fw-bold">Price:</span> {{ $carPart->price1 > 0 ? $carPart->price1 : 'Contact us for price' }}
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

                        <a href=" {{ route('admin.dito-numbers.show', $carPart->ditoNumber) }} "
                           class="btn btn-primary w-100">
                            Dito number {{ $carPart->ditoNumber->dito_number }}
                        </a>


                    </div>
                </div>
            @endforeach
        </div>

        {{ $carParts->links() }}
    </div>
@endsection
