@extends('app')

@section('title', 'Currus Connect - Browse all')

@section('content')
<div class="d-flex flex-column" style="min-height: 100vh opacity: .85; background-image: url('/img/enginedark.jpg'); background-position: center; background-size: cover; background-repeat: no-repeat; ">
    <div class="d-flex flex-grow-1">
        {{-- <x-side-menu-bar :partTypes="$partTypes" /> --}}


        {{-- MIDDLE AND RIGHT SIDE 3/4 --}}
        <div class="container bg-dark text-white flex-grow-1" style="opacity: 0.85">
            <div class="row pt-2">
            </div>
            <x-part-list :parts="$parts" :partTypes="$partTypes" :sortRoute="route('car-parts.search-by-name')"/>
            {{ $parts->appends(request()->query())->links() }}
        </div>
        
    </div>
</div>
@endsection


