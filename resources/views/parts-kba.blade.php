@extends('app')
@section('title', 'Parts - Kba search')
@section('content')
    <div class="container pt-4">
        <div class="row">
            <h1>Search for parts with kba</h1>
            <p>The results might not be 100% accurate and there is a possibility that a part shown here is not fitting. If you are unsure you can always contact us and we can tell you if it fits</p>
            <div class="col-6">
                <div class="card mt-2">
                    <div class="card-header fw-bold">
                        Your search
                    </div>
                    <div class="card-body">
                        <form action="{{ route('car-parts.search-by-code') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="hsn" class="form-label">HSN</label>
                                        <input type="text" class="form-control" name="hsn" value="{{ $search['hsn'] }}">
                                    </div>
                                    <div class="col-6">
                                        <label for="hsn" class="form-label">TSN</label>
                                        <input type="text" class="form-control" name="tsn" value="{{ $search['tsn'] }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="part-type" class="form-label">Part type</label>
                                <select name="part-type" class="form-select" id="part-type">
                                    <option disabled selected>Everything</option>
                                    @foreach($partTypes as $type)
                                        <option @if ($search['part-type'] === $type->id) @endif value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary w-100">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <div class="fw-bold">Car information</div>
                    </div>
                    <div class="card-body">
                        <p>
                            <span class="fw-bold">Name: </span> {{ $kba->full_name }}
                        </p>
                        <p>
                            <span class="fw-bold">Engine capacity: </span> {{ $kba->engine_capacity_in_cm }}cm
                        </p>
                        <p>
                            <span class="fw-bold">Brand: </span> {{ $kba->manufacturer_plaintext }}cm
                        </p>
                        <p>
                            <span class="fw-bold">Commercial name: </span> {{ $kba->commercial_name }}cm
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <h3 class="pt-4">Results</h3>
        <x-part-list :parts="$parts"/>
    </div>
@endsection
