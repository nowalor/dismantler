@extends('app')
@section('title', 'Parts - Model / brand / type search')
@section('content')
    <div class="container">
        <div class="row pt-4">
            <h3>OEM search</h3>
            <div class="col-6 pt-2">
                <div class="card">
                    <div class="card-body">
                        <form action=" {{ route('car-parts.search-by-model') }}">
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
        <x-part-list :parts="$parts" :sortRoute="route('car-parts.search-by-model')"/>
        {{ $parts->links() }}
    </div>
@endsection

