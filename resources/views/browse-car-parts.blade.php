@extends('app')

@section('content')
<div class="d-flex flex-column" style="min-height: 100vh; background-image: url('/img/engine.jpg'); background-position: center; background-size: cover; background-repeat: no-repeat; ">
    <div class="d-flex">
       {{-- <x-side-menu-bar />--}}

        {{-- MIDDLE AND RIGHT SIDE 3/4 --}}
        <div class="container-fluid bg-dark text-white flex-grow-1" style="opacity: .85;">
            <div class="row pt-2">
            </div>
            <x-part-list :parts="$parts" :sortRoute="route('car-parts.search-by-name')"/>
            {{ $parts->links() }}
        </div>

    </div>
</div>
@endsection

