@extends('app')
@section('title', 'Car part - ' . $carPart->name)

@section('content')
    <div class="container mx-auto pt-4">
        @if(session()->has('connection-saved'))
            <div class="alert alert-success mb-2">
                {{ session()->get('connection-saved') }}
            </div>
        @endif

        @if(session()->has('connection-deleted'))
            <div class="alert alert-danger mb-2">
                {{ session()->get('connection-deleted') }}
            </div>
        @endif
        <div class="row col-12">
            <div class="col-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        Information
                    </div>
                    <div class="card-body" style="height: 340px;">
                        <blockquote class="blockquote mb-0">
                            <p>Engine code</p>
                            <footer
                                class="blockquote-footer">{{ $carPart->engine_code ?  : 'Information missing' }}</footer>
                        </blockquote>
                        <blockquote class="blockquote mb-0">
                            <p>Brand</p>
                            <footer class="blockquote-footer">{{ $carPart->ditoNumber?->brand }}</footer>
                        </blockquote>
                        <blockquote class="blockquote mb-0">
                            <p>Production date</p>
                            <footer class="blockquote-footer">{{ $carPart->ditoNumber?->production_date }}</footer>
                        </blockquote>
                        <blockquote class="blockquote mb-0">
                            <p>Dito number</p>
                            <footer class="blockquote-footer">{{ $carPart->ditoNumber?->dito_number }}</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        German dismantlers
                        <form action="" method="POST"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="is_selection_completed" value="1"/>
                            <button class="btn btn-primary btn-sm">Selection completed ☑️</button>
                        </form>
                    </div>
                    <div class="card-body" style=" max-height: 340px; overflow-y: scroll;">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>HSN</th>
                                <th>TSN</th>
                                <th>Engine type connections</th>
                                <th>Make</th>
                                <th>Commercial name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($carPart->ditoNumber?->germanDismantlers as $dismantler)
                                <tr>
                                    <th>{{ $dismantler->id }}</th>
                                    <td>{{ $dismantler->hsn }}</td>
                                    <td>{{ $dismantler->tsn }}</td>
                                    <td>{{ $dismantler->engineTypes->count() }}</td>
                                    <td>{{ $dismantler->make ?? 'null'  }}</td>
                                    <td>{{ $dismantler->commercial_name }}</td>
                                    <td class="d-flex gap-1">
                                        @csrf

                                        @if(
                                            $carPart->engine_code &&
                                            $carPart->engine_type_id &&
                                            !$dismantler->engineTypes->contains($carPart->engine_type_id)
                                        )
                                            <form action="{{ route('admin.kba.store-connection', $dismantler) }}"
                                                  method="POST">
                                                @csrf
                                                <input type="hidden" name="engine-type-id"
                                                       value="{{ $carPart->engine_type_id }}"/>
                                                <button class="btn btn-primary btn-sm">
                                                    Connect
                                                </button>
                                            </form>
                                        @endif
                                        @if($dismantler->engineTypes->contains($carPart->engine_type_id))
                                            <form action="{{ route('admin.kba.delete-connection', $dismantler) }}"
                                                  method="POST">
                                                @csrf
                                                <input type="hidden" name="engine_type_id"
                                                       value="{{ $carPart->engine_type_id }}"/>
                                                <button class="btn btn-danger btn-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                        <a class="btn btn-info btn-sm text-white">View</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <h3 class="pt-4">{{ $carPart->name }}</h3>
        <div class="row">
            <div class="col-6 pt-4">
                <img style="max-height: 500px;" class="w-100" src="{{
    !empty($carPart->carPartImages[0]) ? $carPart->carPartImages[0]?->origin_url :
    asset('no-image-placeholder.jpg')
    }}" alt="">
                @foreach($carPart->carPartImages as $image)
                    <img src="{{ $image->thumbnail_url }}" alt=""/>
                @endforeach
            </div>

            <div class="col-6 pt-4">
                <div class="card">
                    <h5 class="card-header">
                        Part information
                    </h5>
                    <div class="card-body">
                        <p>
                            <span class="fw-bold">Id:</span> {{ $carPart->identifer }}
                        </p>

                        <p>
                            <span class="fw-bold">Engine</span> {{ $carPart->engine_code }}
                        </p>
                        <p>
                            <span class="fw-bold">Part type:</span> {{ $carPart->carPartType->name }}
                        </p>
                        <p>
                            <span class="fw-bold">Price:</span> {{ $carPart->price }}
                        </p>
                        <p>
                            <span class="fw-bold">Quantity:</span> {{ $carPart->quantity }}
                        </p>
                        <p>
                            <span class="fw-bold">Transmission type:</span> {{ $carPart->transmission_type}}
                        </p>
                        <p>
                            <span class="fw-bold">Condition:</span> {{ $carPart->condition }}
                        </p>

                        <p>
                            <span class="fw-bold">Comments:</span> {{ $carPart->comments }}
                        </p>

                        <p>
                            <span class="fw-bold">Kilo watt:</span> {{ $carPart->km }}
                        </p>

                        <p>
                            <span class="fw-bold">Oem number:</span> {{ $carPart->oem_number }}
                        </p>

                        <p>
                            <span class="fw-bold">Shelf number:</span> {{ $carPart->shelf_number }}
                        </p>

                        <p>
                            <span class="fw-bold">Color:</span> {{ $carPart->color}}
                        </p>

                        <p>
                            <span class="fw-bold">Vin number:</span> {{ $carPart->vin_number}}
                        </p>

                        <p>
                            <span class="fw-bold">Engine code:</span> {{ $carPart->engine_code}}
                        </p>

                        <p>
                            <span class="fw-bold">Engine type:</span> {{ $carPart->engine_type}}
                        </p>


                    </div>
                </div>
            </div>
        </div>

        <div class="row pt-4 pb-4">
            <div class="col-6">
                <div class="card">
                    <h3 class="card-header">Notes</h3>
                    <div class="card-body">
                        <div style=" white-space: pre-wrap;">{{ $carPart->notes }}</div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <h3 class="card-header">Comments</h3>
                    <div class="card-body">
                        <div style=" white-space: pre-wrap;">{{ $carPart->comments }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
