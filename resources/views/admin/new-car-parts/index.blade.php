@extends('app')
@section('title', 'Admin - Car parts without connection')
@section('content')
    <div class="container pt-2">
        <h3>Car parts</h3>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        Statistics
                    </div>
                    <div class="card-body">
                        <p class="card-text">Currently you have <span class="fw-bold">{{ $totalCarParts }}</span> total
                            car
                            parts</p>
                        <p class="card-text"><span class="fw-bold">{{ $totalCarPartsWithDitoNumber }}</span> Have a
                            connection
                            to a dito number</p>
                        <p class="card-text"><span class="fw-bold">{{ $totalCarPartsWithoutDitoNumber }}</span> Do not
                            have a
                            connection to a dito number</p>
                        <p class="card-text"><span
                                class="fw-bold">{{ $totalCarPartsWithDitoNumberAndIsInteresting }} </span>have
                            a connection to a dito number and is marked as interesting</p>
                        <p class="card-text"><span class="fw-bold">{{ $totalCarPartsWithKbaConnection }}</span> parts
                            have a
                            connection to a kba through the dito number</p>
                        <p class="card-text"><span class="fw-bold">{{ $totalCarPartsWithoutKbaConnection }}</span> parts
                            are
                            missing a kba connection through the dito number</p>
                        <p class="card-text">
                            <span class="fw-bold">{{ $totalPartsWithEngineType }}</span> have a engine type
                        </p>
                        <p class="card-text">
                            <span class="fw-bold">{{ $totalPartsWithUsableEngineType }}</span> have a usable engine type
                        </p>
                        <p class="card-text">
                            <span class="fw-bold">{{ $totalPartsWithoutEngineType }}</span> do not have a engine type
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card h-100">
                    <div class="card-header">
                        What the statistics mean
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            If a part does NOT have a connection to a dito number it means it either has no dito number
                            or we don't currently have that dito number in our database
                        </p>
                        <div class="card-text">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-6 mt-4">
            <div class="card-header">Filters</div>
            <div class="card-body">
       {{--         <div class="d-flex gap-4">
                    <div>
                        <span class="d-block">Remove</span>
                        <a href="" class="btn btn-primary">Remove filter</a>
                    </div>
                    <div>
                        KBA status
                        <div class="flex">
                            <a href="{{ route('admin.new-parts', ['kba_filter' => 'with_kba', ...request()->all()]) }}"
                               class="btn btn-primary">
                                With KBA
                            </a>
                            <a href="{{ route('admin.new-parts', ['kba_filter' => 'without_kba', ...request()->all()]) }}"
                               class="btn btn-primary">
                                Without KBA
                            </a>
                        </div>
                    </div>
                    <div>
                        Completion
                        <div class="flex">
                            <a href="{{ route('admin.new-parts', ['completion_filter' => 'completed', ...request()->all()]) }}"
                               class="btn btn-primary">
                                Complete
                            </a>
                            <a href="{{ route('admin.new-parts', ['completion_filter' => 'uncompleted', ...request()->all()]) }}"
                               class="btn btn-primary">
                                Incomplete
                            </a>
                        </div>
                    </div>
                    <div>
                        With usable engine type
                        <div class="flex">
                            <a href="{{ route('admin.new-parts', ['engine_type_filter' => 'with_engine_type', ...request()->all()]) }}"
                               class="btn btn-primary">
                                With engine type
                            </a>
                            <a href="{{ route('admin.new-parts', ['engine_type_filter' => 'without_engine_type', ...request()->all()]) }}"
                               class="btn btn-primary">
                                Without engine type
                            </a>
                        </div>
                    </div>
                </div>--}}
                <a href=" {{ route('admin.new-parts', ['filter' => 'dito_number_no_kba_engine_type']) }} " class="btn btn-large btn-primary w-100">
                    With dito number, without kba, with engine type
                </a>
            </div>

        </div>

        <div class="row pt-4">
            <h3 class="pt-4">Showing {{ $carParts->total() }} results</h3>

            @foreach($carParts as $carPart)
                <div class="col-6 mb-3">
                    <div class="card">
                        <div class="card-header">
                            {{  $carPart->name }}
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
                            <p>
                                <span class="fw-bold">KBA:</span> {{ $carPart->kbas }}
                            </p>

                            <a href="{{ route('admin.car-parts.show', $carPart) }}" class="btn btn-primary w-100 mb-2">View</a>
                            <a href=" {{ route('admin.dito-numbers.show', $carPart->ditoNumber) }} "
                               class="btn btn-primary w-100">
                                Dito number {{ $carPart->ditoNumber->dito_number }}
                            </a>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>

        {{ $carParts->links() }}
    </div>
@endsection
