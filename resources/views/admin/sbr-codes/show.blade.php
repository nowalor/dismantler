@extends('app')

@section('title', 'Admin - SBR Codes')
@section('content')
    <div class="container">
        @if(session()->has('message'))
            <div class="alert alert-success mt-4">
                <p class="mb-0">{{ session()->get('message') }}</p>
            </div>
        @endif

        <div class="row pt-4">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        SBR Code
                    </div>
                    <div class="card-body">
                        <p>
                            <span class="fw-bold">#:</span> {{ $sbrCode->id }}
                        </p>
                        <p>
                            <span class="fw-bold">Name:</span> {{ $sbrCode->name }}
                        </p>
                        <p>
                            <span class="fw-bold">code:</span> {{ $sbrCode->sbr_code }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        Connected dito numbers
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Producer</th>
                                <th>Brand</th>
                                <th>Dito number</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($sbrCode->ditoNumbers as $ditoNumber)
                                <tr>
                                    <td>{{ $ditoNumber->id }}</td>
                                    <td>{{ $ditoNumber->producer }}</td>
                                    <td>{{ $ditoNumber->brand }}</td>
                                    <td>{{ $ditoNumber->dito_number}}</td>
                                    <td>
                                        <form method="POST"
                                              action="{{ route('admin.sbr-codes.destroy', $sbrCode)  }}">
                                           @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="dito_number" value="{{ $ditoNumber->id }}">
                                            <button
                                                class="btn btn-sm btn-danger">Delete
                                            </button>
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
        <div class="row pt-2">
            <div class="col-4">
                <form>
                    <div class="mb-3">
                        <label for="search">Search</label>
                        <input type="text" class="form-control" id="search" name="search"
                               placeholder="Search by producer, brand or dito number" value="{{ request('search') }}">
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Connect Dito numbers</div>
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
                            @foreach ($ditoNumbers as $ditoNumber)
                                <tr>
                                    <td>{{ $ditoNumber->id }}</td>
                                    <td>{{ $ditoNumber->producer }}</td>
                                    <td>{{ $ditoNumber->brand }}</td>
                                    <td>{{ $ditoNumber->production_date }}</td>
                                    <td>{{ $ditoNumber->dito_number}}</td>
                                    <td>
                                        <form method="POST"
                                              action="{{ route('admin.sbr-codes.update', $sbrCode)  }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="dito_number" value="{{ $ditoNumber->id }}">
                                            <button
                                                class="btn btn-sm btn-primary">Save
                                            </button>
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
    </div>
@endsection
