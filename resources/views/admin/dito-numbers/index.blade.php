@extends('app')
@section('title', 'Admin - Dito Numbers')
@section('content')
    <div class="container pt-2">
        <div class="col-6">
            <h1 class="pt-4">
                Admin - Dito Numbers
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
        </div>
        <div class="row pt-4 pb-4">
            <div class="col-6">
                <div class="card h-100">
                    <div class="card-header">Statistics</div>
                    <div class="card-body">
                        <p class="card-text">
                            <span class="fw-bold">{{ $totalDitoNumbers }}</span> Total dito numbers
                        </p>
                        <p class="card-text">
                            <span class="fw-bold">{{ $totalDitoNumbersWithKbaConnection }}</span> Total dito numbers
                            with kba connection
                        </p>
                        <p class="card-text">
                            <span class="fw-bold">{{ $totalDitoNumbersWithoutKbaConnection }}</span> Total dito numbers
                            without kba connection
                        </p>
                        <p class="card-text">
                            <span class="fw-bold">{{ $totalDitoNumbersWithEngineConnection }}</span> Total dito numbers
                            with engine connection
                        </p>
                        <p class="card-text">
                            <span class="fw-bold">{{ $totalDitoNumbersWithoutEngineConnection }}</span> Total dito
                            numbers without engine connection
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card h-100">
                    <div class="card-header">What the statistics mean</div>
                    <div class="card-body">
                        <p class="card-text">
                            Total dito numbers, total dito numbers with kba connection and total dito numbers without
                            kba should be pretty self-explanatory.
                        </p>
                        <p class="card-text">
                            If a dito number is connected or not to an engine it is based of the connection going
                            through the kba. So if a dito number is connected to a kba and that kba is connected to an
                            engine, the dito number is connected to an engine.
                        </p>
                    </div>
                </div>
            </div>
        </div>
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
        <div class="col-md-12 mx-auto">
            <div class="card pt-2">
                <div class="card-header d-flex justify-content-between">
                    Dito numbers. Showing {{ $ditoNumbers->total() }} results
                    <form class="d-flex" method="GET" action="{{ route('admin.dito-numbers.index') }}">
                        <input class="form-control me-2" type="search" placeholder="Search" name="search"
                               value="{{ request()->input('search') }}">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Producer</th>
                            <th>Brand</th>
                            <th>Production date</th>
                            <th>Dito number</th>
                            <th>Car parts</th>
                            <th>KBA connections</th>
                            <th>Engine connections</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ditoNumbers as $ditoNumber)
                            <tr>
                                <th>{{ $ditoNumber->id }}</th>
                                <td>{{ $ditoNumber->producer }}</td>
                                <td>{{ $ditoNumber->brand }}</td>
                                <td>{{ $ditoNumber->production_date }}</td>
                                <td>{{ $ditoNumber->dito_number }}</td>
                                <td>{{ $ditoNumber->car_parts_count }}</td>
                                <td>{{ $ditoNumber->german_dismantlers_count }}</td>
                                <td>TODO</td>
                                <td class="d-flex gap-1">
                                    <a href="{{ route('admin.dito-numbers.show', $ditoNumber) }}"
                                       class="btn btn-primary btn-sm">View</a>
                                    <form method="POST" action="{{ route('admin.dito-numbers.update', $ditoNumber) }}">
                                        @csrf
                                        @method('PATCH')
                                        @if($ditoNumber->is_not_interesting)
                                            <input type="hidden" name="is_not_interesting" value="0"/>
                                            <button class="btn btn-primary btn-info text-white btn-sm">Mark as
                                                interesting
                                            </button>
                                        @else
                                            <input type="hidden" name="is_not_interesting" value="1"/>
                                            <button class="btn btn-primary btn-warning text-white btn-sm">Mark as
                                                uninteresting
                                            </button>
                                        @endif
                                    </form>

                                    <form action="{{ route('admin.dito-numbers.update', $ditoNumber) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        @if($ditoNumber->is_selection_completed)
                                            <input type="hidden" name="is_selection_completed" value="0"/>
                                            <button class="btn btn-success btn-sm">Set as incomplete</button>
                                        @else
                                            <input type="hidden" name="is_selection_completed" value="1"/>
                                            <button class="btn btn-success btn-sm">Set as complete</button>
                                        @endif

                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $ditoNumbers->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
