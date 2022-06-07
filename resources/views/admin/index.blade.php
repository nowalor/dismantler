@extends('app')
@section('title', 'Title')
@section('content')
    <div class="container mt-2">
        <div class="flex gap-1" style="margin: 1rem 0;">
            <a href="{{ route('admin.index') }}" class="btn sm btn-info text-white">All relevant</a>

            <a href="{{ route('admin.index', ['filter' => 'uninteresting']) }}" class="btn sm btn-primary">Uninteresting</a>
            <a href="{{ route('admin.index', ['filter' => 'completed']) }}" class="btn sm btn-warning text-white">Selection completed</a>
        </div>
        <div class="col-md-12 mx-auto">
            <div class="card pt-2">
                <div class="card-header d-flex justify-content-between">
                    Dito numbers
                    <form class="d-flex" method="GET" action="{{ route('admin.index') }}">
                        <input class="form-control me-2" type="search" placeholder="Search" name="search" value="{{ request()->input('search') }}">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Producer</th>
                                <th>Brand</th>
                                <th>Production date</th>
                                <th>Dito number</th>
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
                                    <td class="d-flex gap-1">
                                        <a href="{{ route('admin.dito-numbers.show', $ditoNumber) }}" class="btn btn-primary btn-sm">View</a>
                                        <form method="POST" action="{{ route('admin.dito-numbers.show', $ditoNumber) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="is_not_interesting" value="1"/>
                                            <button class="btn btn-primary btn-warning text-white btn-sm">Remove</button>
                                        </form>
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
