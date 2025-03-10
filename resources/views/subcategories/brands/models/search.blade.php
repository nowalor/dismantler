@extends('app')
@section('title', 'Parts for ' . $brand->name . ' - ' . $model->new_name)
@section('content')

<div class="container my-4 pt-4 bg-white rounded shadow">
    <h1 class="text-center text-primary mb-4">
        Parts for {{ $brand->name }} - {{ $model->new_name }}
    </h1>

    <div class="row justify-content-center">
        @forelse ($carParts as $part)
            <div class="col-md-4 mb-4">
                <div class="p-3 border rounded bg-light shadow-sm">
                    <h5 class="text-dark">{{ $part->name }}</h5>
                    <p class="text-muted">{{ $part->description }}</p>
                </div>
            </div>
        @empty
            <p class="text-muted">No parts available for this selection.</p>
        @endforelse
    </div>
</div>

@endsection
