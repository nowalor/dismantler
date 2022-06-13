@extends('app')
@section('title' ,'Single kba')

@section('content')
    <div class="container pt-2">
        <div class="card">
            <div class="card-header">Selected Kba</div>
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
            </div>
        </div>
    </div>
@endsection
