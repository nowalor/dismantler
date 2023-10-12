@extends('app')
@section('title', 'Remove reservation')
@section('content')
    <div class="container mx-auto pt-4">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        Remove reservation {{ $reservation->carPart->article_nr_at_dismantler }}
                    </div>

                    <div class="card-body">
                        <p>
                            <span class="fw-bold">Article nr: </span>{{$reservation->carPart->article_nr_at_dismantler}}
                        </p>
                        <p>
                            <span class="fw-bold">Name: </span>{{$reservation->carPart->name}}
                        </p>

                        <form action="{{ route('reservations.destroy', $reservation) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Remove reservation</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
