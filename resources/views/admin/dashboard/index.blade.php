@extends('app')
@section('title', 'Admin - Dashboard')
@section('content')
    <div class="container pt-2">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="col-6">
            <h1 class="pt-4">
                Admin - Dashboard
            </h1>
            <p>Here you are able to view statistical information on the dito numbers and do some operations on them. You
                can:</p>
            <ol class="list-group list-group-numbered">
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Subheading</div>
                        Cras justo odio
                    </div>
                    <span class="badge bg-primary rounded-pill">14</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Subheading</div>
                        Cras justo odio
                    </div>
                    <span class="badge bg-primary rounded-pill">14</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Subheading</div>
                        Cras justo odio
                    </div>
                    <span class="badge bg-primary rounded-pill">14</span>
                </li>
            </ol>
        <label class="fw-bold">Relevancy</label>
        <div class="flex gap-2">
            <a href="{{ route( 'admin.dito-numbers.index',  array_merge(request()->all(), ['filter' => 'all'])) }}"
               class="btn sm btn-info">All</a>
            <a href="{{ route( 'admin.dito-numbers.index', array_merge(request()->all(), ['filter' => 'all_relevant'])) }}"
               class="btn sm btn-info">All
                relevant</a>
            <a href="{{ route( 'admin.dito-numbers.index' , array_merge(request()->all(), ['filter' => 'uninteresting'])) }}"
               class="btn sm btn-primary">Uninteresting</a>
            <a href="{{ route( 'admin.dito-numbers.index' , array_merge(request()->all(), ['filter' => 'completed'])) }}"
               class="btn sm btn-warning text-white">Selection completed</a>
        </div>
        <label class="fw-bold">Connection</label>
        <div class="flex gap-2">
            <a href="{{ route( 'admin.dito-numbers.index', array_merge(request()->all(), ['kba_connection' => 'has'])) }}"
               class="btn sm btn-info text-white @if(request()->input('kba_connection') === 'has') opacity-50 @endif">With
                kba
                @if(request()->input('kba_connection') === 'has')
                    🗑️
                @endif
            </a>
            <a href="{{ route( 'admin.dito-numbers.index' , array_merge(request()->all(), ['kba_connection' => 'dont_have'])) }}"
               class="btn sm btn-info text-white @if(request()->input('kba_connection') === 'dont_have') opacity-50 @endif">Without
                kba
                @if(request()->input('kba_connection') === 'dont_have')
                    🗑️
                @endif
            </a>

            <a href="{{ route( 'admin.dito-numbers.index', ['engine_connection' => 'has']) }}"
               class="btn sm btn-info text-white @if(request()->input('engine_connection') === 'has') opacity-50 @endif">With
                engines
                @if(request()->input('engine_connection') === 'has')
                    🗑️
                @endif
            </a>
            <a href="{{ route( 'admin.dito-numbers.index', ['engine_connection' => 'dont_have'])}}"
               class="btn sm btn-info text-white @if(request()->input('engine_connection') === 'dont_have') opacity-50 @endif">Without
                engines
                @if(request()->input('engine_connection') === 'dont_have')
                    🗑️
                @endif
            </a>

        </div>
    </div>
@endsection
