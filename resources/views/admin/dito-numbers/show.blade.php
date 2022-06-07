@extends('app')
@section('title', $ditoNumber->name)
@section('content')
    <div class="container">
        @if(session()->has('success'))
            <div class="alert alert-success mt-4 pt-2 col-6"">
                {{ session()->get('success') }}
            </div>
        @endif
        @if(session()->has('removed'))
            <div class="alert alert-danger mt-4 pt-2 col-6">
                {{ session()->get('removed') }}
            </div>
        @endif
        <div class="row col-12 pt-4">
            <div class="col-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        Selected Dito numbers
                        <div>
                            <a href="{{ route('admin.dito-numbers.show', $ditoNumber->id - 1) }}" class="btn btn-primary btn-sm"><-Prev</a>
                            <a href="{{ route('admin.dito-numbers.show', $ditoNumber->id + 1) }}" class="btn btn-primary btn-sm">Next-></a>
                            <a href="{{ route('admin.index') }}" class="btn btn-success btn-sm">All</a>
                        </div>
                    </div>
                    <div class="card-body" style="height: 340px;">
                        <blockquote class="blockquote mb-0">
                            <p>Producer</p>
                            <footer class="blockquote-footer">{{ $ditoNumber->producer }}</footer>
                        </blockquote>
                        <blockquote class="blockquote mb-0">
                            <p>Brand</p>
                            <footer class="blockquote-footer">{{ $ditoNumber->brand }}</footer>
                        </blockquote>
                        <blockquote class="blockquote mb-0">
                            <p>Production date</p>
                            <footer class="blockquote-footer">{{ $ditoNumber->production_date }}</footer>
                        </blockquote>
                        <blockquote class="blockquote mb-0">
                            <p>Dito number</p>
                            <footer class="blockquote-footer">{{ $ditoNumber->dito_number }}</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        Already selected
                    </div>
                    <div class="card-body" style=" max-height: 340px; overflow-y: scroll;">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>HSN</th>
                                <th>TSN</th>
                                <th>Plaintext</th>
                                <th>Make</th>
                                <th>Commercial name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($relatedDismantlers as $dismantler)
                                <tr>
                                    <th>{{ $dismantler->id }}</th>
                                    <td>{{ $dismantler->hsn }}</td>
                                    <td>{{ $dismantler->tsn }}</td>
                                    <td>{{ $dismantler->manufacturer_plaintext }}</td>
                                    <td>{{ $dismantler->make ?? 'null'  }}</td>
                                    <td>{{ $dismantler->commercial_name }}</td>
                                    <td>
                                        <form action="{{ route('test.delete', [$ditoNumber, $dismantler]) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mx-auto pt-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Select German Dismantler
                    <form class="d-flex" method="GET" action="{{ route('admin.dito-numbers.show', $ditoNumber) }}">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search" value="{{ request()->input('search') }}">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
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
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($germanDismantlers as $dismantler)
                            <tr>
                                <th>{{ $dismantler->id }}</th>
                                <td>{{ $dismantler->hsn }}</td>
                                <td>{{ $dismantler->tsn }}</td>
                                <td>{{ $dismantler->manufacturer_plaintext }}</td>
                                <td>{{ $dismantler->make ?? 'null' }}</td>
                                <td>{{ $dismantler->commercial_name }}</td>
                                <td>{{ $dismantler->date_of_allotment_of_type_code_number }}</td>
                                <td>{{ $dismantler->max_net_power_in_kw }}</td>
                                <td>{{ $dismantler->engine_capacity_in_cm }}</td>
                                <td>
                                    <form method="POST"
                                          action="{{ route('test.store', ['ditoNumberId' => $ditoNumber->id, 'dismantlerId' => $dismantler->id]) }}">
                                        @csrf
                                        <button class="btn btn-primary btn-sm">Select</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $germanDismantlers->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
