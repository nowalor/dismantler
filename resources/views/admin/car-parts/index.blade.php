@extends('app')
@section('title', 'Car-parts')
@section('content')
    <div class="container mx-auto pt-4">
        <h2>Parts</h2>
        <div class="col-12 d-flex flex-wrap">
            @foreach($parts as $part)
                <div class="col-4">
                    <div class="card">
                        <h5 class="card-header">{{ $part->item_code }}</h5>
                        <img style="height:400px; object-fit: cover;" class="card-img-bottom" src="{{ count($part->carPartImages) ? $part->carPartImages[0]->origin_url : ''}}" alt="Card image cap">

                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection


