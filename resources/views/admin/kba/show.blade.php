@extends('app')
@section('title' ,'Single kba')

@section('content')
    <div class="container pt-2">
        @if(session()->has('connection-saved'))
            <div class="alert alert-success">
                {{ session()->get('connection-saved') }}
            </div>
        @endif
        @if(session()->has('connection-deleted'))
            <div class="alert alert-danger">
                {{ session()->get('connection-deleted') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                Selected Kba
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>HSN</th>
                        <th>TSN</th>
                        <th>Plaintext</th>
                        <th>Make</th>
                        <th>Commercial name</th>
                        <th>Date</th>
                        <th>Max net</th>
                        <th>Engine</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>{{ $kba->id }}</th>
                        <td>{{ $kba->hsn }}</td>
                        <td>{{ $kba->tsn }}</td>
                        <td>{{ $kba->manufacturer_plaintext }}</td>
                        <td>{{ $kba->make ?? 'null' }}</td>
                        <td>{{ $kba->commercial_name }}</td>
                        <td>{{ $kba->date_of_allotment_of_type_code_number }}</td>
                        <td>{{ $kba->max_net_power_in_kw }}</td>
                        <td>{{ $kba->engine_capacity_in_cm }}</td>
                    </tr>
                    </tbody>
                </table>
                <div class="mt-2">
                    Selected engine types:
                    <div class="d-flex gap-1">
                        @foreach($relatedEngineTypes as $engineType)
                            <form action="{{ route('admin.kba.delete-connection', $kba) }}" method="POST">
                                @csrf
                                <input type="hidden" name="engine_type_id" value="{{ $engineType->id }}">
                                <button class="btn btn-danger btn-sm">
                                    {{ $engineType->name }}
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


        <div class="card mt-2">
            <div class="card-header d-flex justify-content-between">
                Select engine types
                <form action="{{ route('admin.kba.show', $kba) }}" class="d-flex gap-1">
                    <input type="text" class="form-control" placeholder="Search" name="search"
                           value="{{ request()->input('search') }}">
                    <button class="btn btn-primary">Search</button>
                </form>
            </div>
            <div class="card-body">
                <div class="d-flex gap-1 flex-wrap">
                    @foreach($engineTypes as $engineType)
                        <form action="{{ route('admin.kba.store-connection', $kba) }}" method="POST">
                            @csrf
                            <input type="hidden" name="engine-type-id" value="{{ $engineType->id }}"/>
                            <button class="btn btn-sm btn-primary">{{ $engineType->name }}</button>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
