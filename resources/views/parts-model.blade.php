@extends('app')

@section('title', 'Parts - Model / brand / type search')

@section('content')
<div class="d-flex flex-column" style="min-height: 100vh; background-image: url('/img/engine.jpg'); background-position: center; background-size: cover; background-repeat: no-repeat;">
    <div class="d-flex flex-grow-1">
        {{-- LEFT SIDE MENU BAR // PARTS NAVIGATION BAR 1/4 --}}
        <x-side-menu-bar />

        {{-- MIDDLE AND RIGHT SIDE 3/4 --}}
        <div class="container-fluid bg-dark text-white flex-grow-1" style="opacity: .85">
            <div class="row pt-2">
                <div class="col-12">
                    <div class="card bg-dark text-white">
                        <div class="card-body">
                            <p>
                                <strong>{{__('model-brand')}}:</strong> {{ $dito->producer }} |
                                <strong>{{__('model-model')}}:</strong> {{ $dito->new_name }}
                                
                                @if($type && !empty($type->name))
                                    | <strong>{{__('model-part-type')}}:</strong> {{ $type->name }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <x-part-list :parts="$parts" :sortRoute="route('car-parts.search-by-model')"/>
            {{ $parts->links() }}
        </div>
    </div>
</div>
@endsection
