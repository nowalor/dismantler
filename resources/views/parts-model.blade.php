@extends('app')
@section('title', 'Parts - Model / brand / type search')
@section('content')
    <div class="container">
        <div class="row pt-4">
            <h3>OEM search</h3>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">Your search</div>
                    <div class="card-body">
                        <form action=" {{ route('car-parts.search-by-oem') }}">
                            <div class="mb-3">
                                <label class="label" for="oem">Brand</label>
                                <input class="form-control" type="text" id="oem" name="oem" value="{{ $dito->producer }}">
                            </div>

                            <div class="mb-3">
                                <label class="label" for="oem">Brand</label>
                                <input class="form-control" type="text" id="oem" name="oem" value="{{ $dito->new_name }}">
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Part of type</label>
                                <select name="type_id" id="type" class="form-select">
                                    <option value="-1" selected disabled>Select a type</option>
                                    @foreach($types as $typeItem)
                                        <option @if($typeItem->id === $type?->id) selected
                                                @endif value="{{ $typeItem->id }}">{{ $typeItem->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary w-100">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <h3 class="pt-4">Results</h3>
        <x-part-list :parts="$parts"/>
        {{ $parts->links() }}
    </div>
@endsection

