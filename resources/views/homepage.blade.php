@extends('app')


@section('content')
    <div class="cta">
        <div class="card col-3 mx-auto" style="z-index:5; top:20vh;">
            <div class="card-body">
                @error('error')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
                @enderror
                @error('error2')
                <div class="alert alert-danger">
                    If you think this is a mistake please
                    <a target="_blank" href="{{ route('contact') }}">contact us.</a>
                </div>
                @enderror

                @error('error3')
                <div class="alert alert-danger">
                    If you are sure the HSN + TSN is correct please
                    <a target="_blank" href="{{ route('contact') }}">contact us.</a>
                </div>
                @enderror
                <form action="{{ route('car-parts.index') }}">
                    <div class="mb-3">
                        <label for="car_model" class="form-label">Select car model</label>
                        <select class="form-select" name="brand" id="car_model">
                            <option selected disabled>Select car model(optional)</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->name }}"
                                        @if($brand->name === old('brand')) selected @endif>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="hsn" class="form-label">HSN</label>
                                <input type="text" class="form-control" name="hsn" value="{{ old('hsn') }}">
                            </div>
                            <div class="col-6">
                                <label for="hsn" class="form-label">TSN</label>
                                <input type="text" class="form-control" name="tsn" value="{{ old('tsn') }}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="hsn" class="form-label">Advanced search</label>
                        <input type="text" class="form-control" name="advanced_search"
                               value="{{ old('advanced_search') }}">
                    </div>

                    <div class="mb-3">
                        <label>Search by</label>
                        <div class="row">
                            <div class="row">
                                <div class="col-6">
                                    <input class="form-check-input" type="radio" name="search_by" checked
                                           value="everything">
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
