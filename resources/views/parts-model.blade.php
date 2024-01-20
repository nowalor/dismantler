@extends('app')
@section('title', 'Parts - Model / brand / type search')
@section('content')
    <div class="container">
        <h3 class="pt-4">Results</h3>
        <x-part-list :parts="$parts"/>

        {{ $parts->links() }}
    </div>
@endsection

