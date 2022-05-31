@extends('app')
@section('title', 'Title')
@section('content')
    <div class="container">
        <div class="col-md-12 mx-auto pt-2">
            <div class="card">
                <div class="card-header">Dito numbers</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Producer</th>
                                <th>Brand</th>
                                <th>Production date</th>
                                <th>Dito number</th>
                                <th>Has relations</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ditoNumbers as $ditoNumber)
                                <tr>
                                    <th>{{ $ditoNumber->id }}</th>
                                    <td>{{ $ditoNumber->producer }}</td>
                                    <td>{{ $ditoNumber->brand }}</td>
                                    <td>{{ $ditoNumber->production_date }}</td>
                                    <td>{{ $ditoNumber->dito_number }}</td>
                                    <td>false</td>
                                    <td>
                                        <a href="{{ route('admin.dito-numbers.show', $ditoNumber) }}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $ditoNumbers->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
