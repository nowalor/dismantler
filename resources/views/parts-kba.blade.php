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
                                @if($search['hsn'] && $search['tsn'])
                                    <strong>HSN:</strong> {{ $search['hsn'] }} |
                                    <strong>TSN:</strong> {{ $search['tsn'] }}
                                @endif
                                
                                @if($type && !empty($type->name))
                                    | <strong>{{ __('model-part-type') }}:</strong> {{ $type->name }}
                                @endif
                            
                                @if(!empty($search['search']))
                                    | <strong>Search:</strong> {{ $search['search'] }}
                                @endif
                            </p>
                            
                        </div>
                    </div>
                </div>
            </div>
            <x-part-list :parts="$parts" :search="$search" :partTypes="$partTypes" :sortRoute="route('car-parts.search-by-code')"/>
            @if($parts instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{ $parts->appends(request()->query())->links() }}
            @endif
        </div>
    </div>
</div>
@endsection
