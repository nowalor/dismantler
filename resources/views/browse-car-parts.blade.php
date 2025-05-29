@extends('app')

@section('title', 'Currus-connect.com: ' . __('page-titles.search_all'))


@section('content')
<div class="d-flex flex-column" style="min-height: 100vh opacity: .85; background-image: url('/img/enginedark.jpg'); background-position: center; background-size: cover; background-repeat: no-repeat; ">
    <div class="d-flex flex-grow-1">
        {{-- <x-side-menu-bar :partTypes="$partTypes" /> --}}

        {{-- MIDDLE AND RIGHT SIDE 3/4 --}}
        <div class="container bg-dark text-white flex-grow-1" style="opacity: 0.85">
            <div class="row pt-2">
                <div class="col-12">
                    @if(!empty(request('search')) || !empty(request('type_id')))
                        <div class="card bg-dark text-white">
                            <div class="card-body">
                                <p class="mb-0 mt-0">
                                    @if($type && !empty($type->name))
                                        <strong class="ml-2">{{ ('Part Type') }}:</strong> {{ $type->name }}
                                    @endif

                                    @if(!empty(request('search'))) |
                                        <strong>{{ ('Search') }}:</strong> {{ request('search') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <x-part-list :parts="$parts" :partTypes="$partTypes" :mainCategories="$mainCategories" :sortRoute="route('car-parts.search-by-name')"/>
            {{-- {{ $parts->appends(request()->query())->links() }} --}}
{{-- <div class="mt-4 d-flex justify-content-center">
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-custom">
            {{ $parts->appends(request()->query())->links() }}
        </ul>
    </nav>
</div> --}}

{{ $parts->links('pagination::simple-bootstrap-5') }}
        </div>

    </div>
</div>
@endsection


