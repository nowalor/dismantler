@extends('app')

@section('title', 'Admin - SBR Codes')
@section('content')
    <div class="container">
        <h1 class="text-center">SBR Codes</h1>
        <div class="row">
            <div class="col md-6">
                <div class="card">
                    <div class="card-header">Filters</div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label class="fw-bold" for="search">Search name</label>
                                <input type="text" class="form-control" id="search" name="search"
                                       value="{{ request()->input('search') }}">
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Dito Connection Type</label>

                                <div class="d-flex gap-2">
                                    <div>
                                        <label for="dito-with">All</label>
                                        <input type="radio" class="form-check-input" name="dito-connection"
                                               value="all" {{ request()->input('dito-connection') === 'all' ? 'checked' : '' }}>
                                    </div>
                                    <div>
                                        <label for="dito-with">With</label>
                                        <input type="radio" class="form-check-input" name="dito-connection"
                                               value="with" {{ request()->input('dito-connection') === 'with' ? 'checked' : '' }}>
                                    </div>
                                    <div>
                                        <label for="dito-with">Without</label>
                                        <input type="radio" class="form-check-input" name="dito-connection"
                                               value="without" {{ request()->input('dito-connection') === 'without' ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Has car parts</label>

                                <div class="d-flex gap-2">
                                    <div>
                                        <label for="dito-with">All</label>
                                        <input type="radio" class="form-check-input" name="car-parts"
                                               value="all" {{ request()->input('car-parts') === 'all' ? 'checked' : '' }}>
                                    </div>
                                    <div>
                                        <label for="dito-with">With</label>
                                        <input type="radio" class="form-check-input" name="car-parts"
                                               value="with" {{ request()->input('car-parts') === 'with' ? 'checked' : '' }}>
                                    </div>
                                    <div>
                                        <label for="dito-with">Without</label>
                                        <input type="radio" class="form-check-input" name="car-parts"
                                               value="without" {{ request()->input('car-parts') === 'without' ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary w-100" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col md-6">
                <div class="card">
                    <div class="card-header">
                        Statistics
                    </div>
                    <div class="card-body">
                        <p><span class="fw-bold">Total results for query</span>: {{ $sbrCodes->total() }}</p>
                        <p><span class="fw-bold">Total SBR Codes with Dito Code</span>: {{ $totalSbrWithDito }}</p>
                        <p><span class="fw-bold">Total SBR Codes without Dito Code</span>: {{ $totalSbrWithoutDito }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if(count($sbrCodes) > 0)
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Sbr code</th>
                            <th>Name</th>
                            <th>Dito numbers</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sbrCodes as $sbrCode)
                            <tr>
                                <td>{{ $sbrCode->id }}</td>
                                <td>{{ $sbrCode->sbr_code }}</td>
                                <td>{{ $sbrCode->name }}</td>
                                <td>{{ $sbrCode->dito_numbers_count }}</td>
                                <td>
                                    <a href="{{ route('admin.sbr-codes.show', $sbrCode->id) }}" class="btn btn-primary">View</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $sbrCodes->links() }}
                @else
                    <p>No SBR Codes found.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
