@extends('app')

@section('title', 'Parts - Number plate search')

@section('content')
    <div class="d-flex flex-column" style="min-height: 100vh; background-image: url('/img/enginedark.jpg'); background-position: center; background-size: cover; background-repeat: no-repeat;">
        <div class="d-flex flex-grow-1">
            <div class="container bg-dark text-white flex-grow-1" style="opacity: 0.85;">
                <x-part-list :parts="$parts" :partTypes="$partTypes" :sortRoute="route('car-parts.search-by-oem')" />
{{--                {{ $parts->appends(request()->query())->links() }}--}}
            </div>
        </div>
    </div>
@endsection
