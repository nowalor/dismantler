@extends('app')
@section('title', 'Category Details')

@section('content')
    <div class="container pt-2">
        @if(session()->has('connection-saved'))
            <div class="alert alert-success">{{ session()->get('connection-saved') }}</div>
        @endif
        @if(session()->has('connection-deleted'))
            <div class="alert alert-danger">{{ session()->get('connection-deleted') }}</div>
        @endif

        {{-- Main Category Section --}}
        <div class="card">
            <div class="card-header">
                <h3>Main Category - {{ $mainCategory->name }}</h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th># ID</th>
                        <th>Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>{{ $mainCategory->id }}</th>
                        <td>{{ $mainCategory->name }}</td>
                    </tr>
                    </tbody>
                </table>

                <h5>Connected Car Part Types</h5>
                <div class="d-flex gap-2 flex-wrap">
                    @foreach($connectedCarPartTypes as $carPartType)
                        <form action="{{ route('admin.categories.disconnect-car-part', $mainCategory) }}" method="POST">
                            @csrf
                            <input type="hidden" name="car_part_type_id" value="{{ $carPartType->id }}">
                            <button class="btn btn-danger btn-sm">
                                {{ $carPartType->name }}
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card mt-2">
            <div class="card-header">
                <h5>Available Car Part Types</h5>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2 flex-wrap">
                    @foreach($unconnectedCarPartTypes as $carPartType)
                        <form action="{{ route('admin.categories.connect-car-part', $mainCategory) }}" method="POST">
                            @csrf
                            <input type="hidden" name="car_part_type_id" value="{{ $carPartType->id }}">
                            <button class="btn btn-primary btn-sm">{{ $carPartType->name }}</button>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
