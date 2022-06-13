@extends('app')
@section('title', 'KBA List')

@section('content')
    <div class="container">
        <div class="col-12">
            <div class="card">
                <div class="card-header">KBA</div>
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
                            <th>
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dismantlers as $dismantler)
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
                                    <a href="{{ route('admin.kba.show', $dismantler) }}" class="btn btn-primary btn-sm">View</a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
