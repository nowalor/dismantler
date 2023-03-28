@extends('app')
@section('title', 'Admin - Engine types')
@section('content')
    <div class="container pt-2">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif

        <h1>Engine types</h1>
        <div class="my-2">
            <div class="d-flex gap-1">
                <a href="{{ route('admin.engine-types.index', ['completed' => 0]) }}" class="btn btn-primary @if(!request()->get('completed')) disabled @endif">Not
                    completed</a>
                <a href="{{ route('admin.engine-types.index', ['completed' => 1]) }}"
                   class="btn btn-primary @if(request()->get('completed')) disabled @endif">Completed</a>
            </div>
        </div>
        <div class="col-12 row">
            <div class="col-12 mb-2">
                <div class="card">
                    <div class="card-header">Statistics</div>
                    <div class="card-body">
                        <p>Out of <span class="fw-bold">{{ $totalEngineTypes }} </span>only <span
                                class="fw-bold">{{ $totalEngineTypesWithCarPartsAndKba }}</span> have a car part and kba
                            connection. Only those are shown in the list and the statistics</p>
                        <p><span
                                class="fw-bold">Total engine types marked complete: </span>{{ $totalConnectedEngineTypesCount }}
                        </p>
                        <p><span
                                class="fw-bold">Total engine types not marked complete: </span>{{ $totalUnconnectedEngineTypesCount }}
                        </p>
                        <p><span class="fw-bold">Total kba connected: </span>{{ $totalKbaConnected }}</p>
                        <p><span class="fw-bold">Total car parts connected: </span>{{ $totalCarPartsConnected }}</p>
                    </div>
                </div>
            </div>

            <h3 class="my-2">Showing {{ $engineTypes->total() }} results</h3>
            @foreach($engineTypes as $engineType)
                <div class="col-6 mb-2">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            {{ $engineType->name }}

                            <form
                                action="{{ route('admin.engine-types.update', $engineType) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="completed" value="{{ $engineType->connection_completed_at ? 'incomplete' : 'complete' }}">
                                @if(is_null($engineType->connection_completed_at))
                                    <button class="btn btn-sm btn-primary">Mark completed ☑️</button>
                                @else
                                    <button class="btn btn-sm btn-danger">Mark not completed ❌</button>
                                @endif
                            </form>
                        </div>
                        <div class="card-body">
                            <p><span class="fw-bold">Engine name: </span> {{ $engineType->name }}</p>
                            <p><span
                                    class="fw-bold">Connections to car parts: </span>{{ $engineType->car_parts_count }}
                            </p>
                            <p><span
                                    class="fw-bold">Connections to KBA: </span>{{ $engineType->german_dismantlers_count }}
                            </p>
                            <label class="fw-bold">Kba list: </label>
                            <br/>
                            <div class="mb-4" style="max-height: 200px; overflow-y: scroll;">
                                @foreach($engineType->germanDismantlers as $germanDismantler)
                                    <form
                                        action="{{ route(
                                            'admin.engine-types.destroy',
                                            ['engineType' => $engineType, 'germanDismantler' =>  $germanDismantler]
                                            ) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger m-1">
                                            (KBA: {{ $germanDismantler->hsn }}
                                            {{ $germanDismantler->tsn }})
                                            {{ $germanDismantler->model_plaintext }}
                                            {{ $germanDismantler->manufacturer_plaintext }}
                                            {{ $germanDismantler->commercial_name }}
                                            ({{ $germanDismantler->max_net_power_in_kw }} kw)
                                        </button>
                                    </form>
                                @endforeach
                            </div>
                            <a href="{{ route('admin.engine-types.show', $engineType) }}"
                               class="btn  btn-lg btn-primary w-100">View</a>
                        </div>
                    </div>
                </div>
            @endforeach
            {{ $engineTypes->links() }}
        </div>
@endsection
