@extends('app')
@section('title', 'Admin - Fenix Parrts')
@section('content')
    <div class="container">
        <div class="d-flex flex-wrap">
            @foreach($carParts as $carPart)
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            Hello
                        </div>
                        <div class="card-body">
                            <img class="card-img-bottom"
                                 src="{{ count($carPart->carPartImages) ? asset("storage/img/car-part/{$carPart->id}/{$carPart->carPartImages[0]->image_name}") : '' }}"
                                 alt="">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
