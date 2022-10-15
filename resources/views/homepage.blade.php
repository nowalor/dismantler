@extends('app')


@section('content')
    <div class="cta">
        <div class="card col-3 mx-auto" style="z-index:5; top:20vh;">
            <div class="card-body">
                @error('hsn_or_tsn_missing')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
                @enderror
                <form action="{{ route('car-parts.index') }}">
                    <div class="mb-3">
                        <label for="car_model" class="form-label">Select car model</label>
                        <select class="form-select" name="brand" id="car_model">
                            <option></option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="hsn" class="form-label">HSN</label>
                                <input type="text" class="form-control" name="hsn">
                            </div>
                            <div class="col-6">
                                <label for="hsn" class="form-label">TSN</label>
                                <input type="text" class="form-control" name="tsn">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="hsn" class="form-label">Advanced search</label>
                        <input type="text" class="form-control" name="advanced_search">
                    </div>

                    <div class="mb-3">
                        <label>Search by</label>
                        <div class="row">
                            <div class="row">
                                <div class="col-6">
                                    <input class="form-check-input" type="radio" name="search_by" checked value="everything">
                                    <label class="form-check-label">
                                        Everything
                                    </label>
                                </div>

                                <div class="col-6">
                                    <input class="form-check-input" type="radio" name="search_by" value="engine_type">
                                    <label class="form-check-label">
                                        Engine type
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary w-100 uppercase">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection('content')
