@extends('app')
@section('title', 'Parts - Search')
@section('content')
    <div class="container">
        <div class="row pt-4">
            <div class="col-6 pt-2">
            </div>
        </div>
        <h3 class="pt-4 fw-bold">Results</h3>
        <x-part-list :parts="$parts" :sortRoute="route('car-parts.search-by-name')"/>
        {{ $parts->links() }}
    </div>
@endsection

