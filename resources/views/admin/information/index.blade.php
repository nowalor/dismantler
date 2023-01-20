@extends('app')
@section('title', 'Admin - Information page')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($ditoNumbers as $ditoNumber => $carPartsCount)
                <div class="col-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            {{ $ditoNumber }}
                        </div>
                        <div class="card-body">
                            <p class="card-text">We have <span class="fw-bold">{{ $carPartsCount }}</span> for this dito
                            </p>

                            <a href="{{ route('admin.information.show', $ditoNumber) }}" class="btn btn-primary w-100">Show
                                car parts</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
