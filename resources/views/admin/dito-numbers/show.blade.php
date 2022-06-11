@extends('app')
@section('title', $ditoNumber->name)
@section('content')
    <div class="container">
        @if(session()->has('success'))
            <div class="alert alert-success mt-4 pt-2 col-6">
                {{ session()->get('success') }}
            </div>
        @endif
        @if(session()->has('removed'))
            <div class="alert alert-danger mt-4 pt-2 col-6">
                {{ session()->get('removed') }}
            </div>
        @endif
        <div class="row col-12 pt-4">
            <div class="col-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        Selected Dito numbers
                        <div>
                            <a href="{{ route('admin.dito-numbers.show', $ditoNumber->id - 1) }}"
                               class="btn btn-primary btn-sm"><-Prev</a>
                            <a href="{{ route('admin.dito-numbers.show', $ditoNumber->id + 1) }}"
                               class="btn btn-primary btn-sm">Next-></a>
                            <a href="{{ route('admin.index') }}" class="btn btn-success btn-sm">All</a>
                        </div>
                    </div>
                    <div class="card-body" style="height: 340px;">
                        <blockquote class="blockquote mb-0">
                            <p>Producer</p>
                            <footer class="blockquote-footer">{{ $ditoNumber->producer }}</footer>
                        </blockquote>
                        <blockquote class="blockquote mb-0">
                            <p>Brand</p>
                            <footer class="blockquote-footer">{{ $ditoNumber->brand }}</footer>
                        </blockquote>
                        <blockquote class="blockquote mb-0">
                            <p>Production date</p>
                            <footer class="blockquote-footer">{{ $ditoNumber->production_date }}</footer>
                        </blockquote>
                        <blockquote class="blockquote mb-0">
                            <p>Dito number</p>
                            <footer class="blockquote-footer">{{ $ditoNumber->dito_number }}</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        Already selected
                        <form action="{{ route('admin.dito-numbers.update', $ditoNumber) }}" method="POST"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="is_selection_completed" value="1"/>
                            <button class="btn btn-primary btn-sm">Selection completed ☑️</button>
                        </form>
                    </div>
                    <div class="card-body" style=" max-height: 340px; overflow-y: scroll;">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>HSN</th>
                                <th>TSN</th>
                                <th>Plaintext</th>
                                <th>Make</th>
                                <th>Commercial name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($relatedDismantlers as $dismantler)
                                <tr>
                                    <th>{{ $dismantler->id }}</th>
                                    <td>{{ $dismantler->hsn }}</td>
                                    <td>{{ $dismantler->tsn }}</td>
                                    <td>{{ $dismantler->manufacturer_plaintext }}</td>
                                    <td>{{ $dismantler->make ?? 'null'  }}</td>
                                    <td>{{ $dismantler->commercial_name }}</td>
                                    <td>
                                        <form action="{{ route('test.delete', [$ditoNumber, $dismantler]) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 pt-4">
            <div class="card">
                <div class="card-header">Filters</div>
                <div class="card-body d-flex">
                    <form action="{{ route('admin.dito-numbers.show', $ditoNumber) }}">
                        <div class="d-flex gap-2">
                            <div>
                                <label>Plaintext</label>
                                <input value="{{ request()->input('plaintext') }}" list="plaintext-list"
                                       name="plaintext" class="form-select">
                                <datalist id="plaintext-list">
                                    @foreach($plaintexts as $option)
                                        <option @if(request()->input('plaintext') == $option->name) selected
                                                @endif value="{{ $option->name }}">{{ $option->name }}
                                        </option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div>
                                <label>Commercial name</label>
                                <input name="commercial_name" value="{{ request()->input('commercial_name') }}"
                                       list="commercial-name-list" name="commercial_name" class="form-select">
                                <datalist>
                                    @foreach($commercialNames as $option)
                                        <option @if(request()->input('commercial_name') == $option->name) selected
                                                @endif value="{{ $option->name }}">{{ $option->name }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div>
                                <label>Make</label>
                                <input type="text" name="make" value="{{ request()->input('make') }}"
                                       class="form-control">
                            </div>
                        </div>

                        <div class="pt-4 d-flex gap-2">
                            <div>
                                <label for="date">Date from</label>
                                <div class="input-group date" id="datepicker2">
                                    <input name="date_from" type="text" class="form-control"
                                           value="{{ request()->input('date_from') }}">
                                    <span class="input-group-append">
                                    <span class="input-group-text bg-white d-block">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </span>
                                </div>
                            </div>

                            <div>
                                <label for="date">Date to:</label>
                                <div class="input-group date" id="datepicker">
                                    <input name="date_to" type="text" class="form-control"
                                           value="{{ request()->input('date_to') }}">
                                    <span class="input-group-append">
                                    <span class="input-group-text bg-white d-block">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </span>
                                </div>
                            </div>

                        </div>

                        <div class="pt-4 d-flex gap-2">
                            <button class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin.dito-numbers.show', $ditoNumber) }}"
                               class="btn btn-warning text-white">Clear filters</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 pt-4">
            Sort by:
            <div class="d-flex gap-2">
                <form action="{{ route('admin.dito-numbers.show', $ditoNumber) }}">
                    <input type="hidden" name="sort_by" value="manufacturer_plaintext">
                    <button
                        class="btn btn-sm @if(request()->input('sort_by') === 'plaintext') btn-primary @else btn-light @endif">
                        Plaintext
                    </button>
                </form>

                <form action="{{ route('admin.dito-numbers.show', $ditoNumber) }}">
                    <input type="hidden" name="sort_by" value="make">
                    <button
                        class="btn btn-sm @if(request()->input('sort_by') === 'make') btn-primary @else btn-light @endif">
                        Make
                    </button>
                </form>

                <form action="{{ route('admin.dito-numbers.show', $ditoNumber) }}">
                    <input type="hidden" name="sort_by" value="date_of_allotment">
                    <button
                        class="btn btn-sm @if(request()->input('sort_by') === 'date_of_allotment') btn-primary @else btn-light @endif">
                        Date
                    </button>
                </form>

                <form action="{{ route('admin.dito-numbers.show', $ditoNumber) }}">
                    <input type="hidden" name="sort_by" value="commercial_name">
                    <button
                        class="btn btn-sm @if(request()->input('sort_by') === 'commercial_name') btn-primary @else btn-light @endif">
                        Commercial name
                    </button>
                </form>
            </div>
        </div>

        <div class="col-12 mx-auto pt-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Select German Dismantler
                </div>
                <div class="card-body">
                    <form method="POST"
                          action="{{ route('test.store', ['ditoNumberId' => $ditoNumber->id, 'dismantlerId' => $dismantler->id]) }}">
                        @csrf

                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>HSN</th>
                                <th>TSN</th>
                                <th>Plaintext</th>
                                <th>Make</th>
                                <th>Commercial name</th>
                                <th>Date</th>
                                <th>Max net</th>
                                <th>Engine</th>
                                <th>
                                    <button class="btn btn-primary btn-sm">Save selected</button>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($germanDismantlers as $dismantler)
                                <tr>
                                    <th>{{ $dismantler->id }}</th>
                                    <td>{{ $dismantler->hsn }}</td>
                                    <td>{{ $dismantler->tsn }}</td>
                                    <td>{{ $dismantler->manufacturer_plaintext }}</td>
                                    <td>{{ $dismantler->make ?? 'null' }}</td>
                                    <td>{{ $dismantler->commercial_name }}</td>
                                    <td>{{ $dismantler->date_of_allotment_of_type_code_number }}</td>
                                    <td>{{ $dismantler->max_net_power_in_kw }}</td>
                                    <td>{{ $dismantler->engine_capacity_in_cm }}</td>
                                    <td>
                                        <label id="dismantler-checkbox">Select</label>
                                        <input name="dismantler-checkbox[]" class="form-check-input" type="checkbox"
                                               id="dismantler-checkbox" value="{{ $dismantler->id }}"
                                        >
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </form>
                    {{ $germanDismantlers->links() }}
                </div>
            </div>
        </div>
        @endsection
        @section('js')
            <script type="text/javascript">
                $(function () {
                    $('#datepicker').datepicker();
                    $('#datepicker2').datepicker();
                });
            </script>
@endsection
