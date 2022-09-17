@extends('app')


@section('content')
    <div class="cta">
        <div class="card col-3 mx-auto" style="z-index:5; top:20vh;">
            <div class="card-body">
                <form action="{{ route('car-parts.index') }}">
                    <div class="mb-3">
                        <label for="" class="form-label">Select car model</label>
                        <input type="text" class="form-control">
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
                        <input type="text" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Search by</label>
                        <div class="row">
                            <div class="row">
                                <div class="col-6">
                                    <input class="form-check-input" type="radio" >
                                    <label class="form-check-label">
                                        Everything
                                    </label>
                                </div>

                                <div class="col-6">
                                    <input class="form-check-input" type="radio" >
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
