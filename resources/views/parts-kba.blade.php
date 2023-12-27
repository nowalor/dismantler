@extends('app')

@section('title', 'Parts - Kba search')
@section('content')
    <div class="container">
        <x-part-list :parts="$parts"/>
    </div>
@endsection
