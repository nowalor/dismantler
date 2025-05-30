@extends('app')

@section('title', 'Parts - Model / Brand / Type Search')

@section('content')
<div class="d-flex flex-column" style="min-height: 100vh; background-image: url('/img/enginedark.jpg'); background-position: center; background-size: cover; background-repeat: no-repeat;">
    <div class="d-flex flex-grow-1">
        <div class="container bg-dark text-white flex-grow-1" style="opacity: .85">
            <div class="row pt-2">
                <div class="col-12">
                    <div class="card bg-dark text-white">
                        <div class="card-body">
                            <p class="mb-0 mt-0">
                                <strong>{{ __('model-brand') }}:</strong> {{ $dito->producer }} |
                                <strong>{{ __('model-model') }}:</strong> {{ $dito->new_name }}

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

            {{-- Part list and search form --}}
            <x-part-list :parts="$parts" :search="$search" :partTypes="$partTypes" :mainCategories="$mainCategories" :sortRoute="route('car-parts.search-by-model')" />

            {{-- Pagination links --}}
     {{--       @if($parts instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{ $parts->appends(request()->query())->links() }}
            @endif--}}
            {{ $parts->links() }}
        </div>
    </div>
</div>
@endsection
