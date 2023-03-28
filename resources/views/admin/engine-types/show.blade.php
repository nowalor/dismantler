@extends('app')
@section('title', 'Admin - Engine types - ' . $engineType->name)
@section('content')
    <div class="container pt-2">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="d-flex justify-content-between">
            <div>
                <h2 class="pt-2">Engine type: {{ $engineType->name }}</h2>
                <h3><span class="fw-bold">Kba connections: </span> {{ $engineType->germanDismantlers->count() }}</h3>
                <h3><span class="fw-bold">Car part connections: </span> {{ $engineType->car_parts_count }}</h3>
            </div>
            <div>
                Completed at: @if($engineType->connection_completed_at)
                    {{ $engineType->connection_completed_at }}
                @else
                    Not completed
                @endif
                    <div>
                        <form action="{{ route('admin.engine-types.update', $engineType ) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="completed"
                                   value="{{ $engineType->connection_completed_at ? 'incomplete' : 'complete' }}">
                            @if(is_null($engineType->connection_completed_at))
                                <button class="btn btn-primary">Mark completed ☑️</button>
                            @else
                                <button class="btn btn-danger">Mark not completed ❌</button>
                            @endif
                        </form>
                    </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">Remove all without selected max wat</div>
                    <div class="card-body">
                        <form action="{{ route('admin.engine-types.delete-max-wat', $engineType) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="mb-3">
                                <label for="">Max wat:</label>
                                <select class="form-select" name="max_wat">
                                    <option value="">Select</option>
                                    @foreach($kbaMaxWat as $maxWat)
                                        <option value="{{ $maxWat }}">{{ $maxWat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-primary w-100">Remove all without selected max wat 🗑️</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <form action="{{ route('admin.engine-types.destroy-multiple', $engineType) }}" method="POST"
                      onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <div class="card-header d-flex justify-content-between">
                        Already selected
                        <input type="hidden" name="is_selection_completed" value="1"/>
                        <button class="btn btn-danger btn-sm">Remove selected 🗑️</button>
                    </div>
                    <div class="card-body" style=" max-height: 340px; overflow-y: scroll;">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>HSN</th>
                                <th>TSN</th>
                                <th>Plaintext</th>
                                <th>Commercial name</th>
                                <th>Make</th>
                                <th>Max wat</th>
                                <th>Engine capacity</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($engineType->germanDismantlers as $dismantler)
                                <tr>
                                    <th>{{ $dismantler->id }}</th>
                                    <td>{{ $dismantler->hsn }}</td>
                                    <td>{{ $dismantler->tsn }}</td>
                                    <td>{{ $dismantler->manufacturer_plaintext }}</td>
                                    <td>{{ $dismantler->commercial_name }}</td>

                                    <td>{{ $dismantler->make ?? 'null'  }}</td>
                                    <td> {{ $dismantler->max_net_power_in_kw }}kw</td>
                                    <td> {{ $dismantler->engine_capacity_in_cm }}CM</td>

                                    <td>
                                        <label for="kba-{{ $dismantler->id }}">Select</label>
                                        <input type="checkbox" name="selected_kba[]" id="kba-{{ $dismantler->id }}"
                                               value="{{ $dismantler->id }}"/>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
