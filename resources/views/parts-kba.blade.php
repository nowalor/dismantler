@extends('app')
@section('title', 'Parts - KBA search')

@section('content')
<div class="d-flex flex-column" style="min-height: 100vh; background-image: url('/img/enginedark.jpg'); background-position: center; background-size: cover; background-repeat: no-repeat;">
    <div class="d-flex flex-grow-1">
        {{-- <x-side-menu-bar :partTypes="$partTypes" /> --}}

        {{-- MIDDLE AND RIGHT SIDE 3/4 --}}
        <div class="container bg-dark text-white flex-grow-1" style="opacity: .85">
            <div class="row pt-2">
                <div class="col-12">
                    <div class="card bg-dark text-white">
                        <div class="card-body">
                            <p class="mb-0 mt-0">
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
            <x-part-list :parts="$parts" :partTypes="$partTypes" :sortRoute="route('car-parts.search-by-code')"/>
            {{ $parts->links() }}
        </div>
    </div>
</div>
@endsection