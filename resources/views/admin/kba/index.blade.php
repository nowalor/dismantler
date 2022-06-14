@extends('app')
@section('title', 'KBA List')

@section('content')
    <div class="container">
        <div class="col-12 pt-4">
            <div class="card">
                <div class="card-header">Filters</div>
                <div class="card-body d-flex">
                    <form action="{{ route('admin.kba.index') }}">
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
                            <a href="{{ route('admin.kba.index') }}"
                               class="btn btn-warning text-white">Clear filters</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 pt-4">
            Sort by:
            <div class="d-flex gap-2">
                <form action="{{ route('admin.kba.index') }}">
                    <input type="hidden" name="sort_by" value="manufacturer_plaintext">

                    <!-- Store existing values in form request-->
                    <input type="hidden" name="plaintext" value="{{ request()->input('plaintext') }}">
                    <input type="hidden" name="commercial_name" value="{{ request()->input('commercial_name') }}">
                    <input type="hidden" name="make" value="{{ request()->input('make') }}">
                    <input type="hidden" name="date_from" value="{{ request()->input('date_from') }}">
                    <input type="hidden" name="date_to" value="{{ request()->input('date_to') }}">

                    <button
                        class="btn btn-sm @if(request()->input('sort_by') === 'plaintext') btn-primary @else btn-light @endif">
                        Plaintext
                    </button>
                </form>

                <form action="{{ request()->getRequestUri()  }}">
                    <input type="hidden" name="sort_by" value="make">

                    <!-- Store existing values in form request-->
                    <input type="hidden" name="plaintext" value="{{ request()->input('plaintext') }}">
                    <input type="hidden" name="commercial_name" value="{{ request()->input('commercial_name') }}">
                    <input type="hidden" name="make" value="{{ request()->input('make') }}">
                    <input type="hidden" name="date_from" value="{{ request()->input('date_from') }}">
                    <input type="hidden" name="date_to" value="{{ request()->input('date_to') }}">

                    <button
                        class="btn btn-sm @if(request()->input('sort_by') === 'make') btn-primary @else btn-light @endif">
                        Make
                    </button>
                </form>

                <form action="{{ route('admin.kba.index') }}">
                    <input type="hidden" name="sort_by" value="date_of_allotment">

                    <!-- Store existing values in form request-->
                    <input type="hidden" name="plaintext" value="{{ request()->input('plaintext') }}">
                    <input type="hidden" name="commercial_name" value="{{ request()->input('commercial_name') }}">
                    <input type="hidden" name="make" value="{{ request()->input('make') }}">
                    <input type="hidden" name="date_from" value="{{ request()->input('date_from') }}">
                    <input type="hidden" name="date_to" value="{{ request()->input('date_to') }}">

                    <button
                        class="btn btn-sm @if(request()->input('sort_by') === 'date_of_allotment') btn-primary @else btn-light @endif">
                        Date
                    </button>
                </form>

                <form action="{{ route('admin.kba.index') }}">
                    <input type="hidden" name="sort_by" value="commercial_name">

                    <!-- Store existing values in form request-->
                    <input type="hidden" name="plaintext" value="{{ request()->input('plaintext') }}">
                    <input type="hidden" name="commercial_name" value="{{ request()->input('commercial_name') }}">
                    <input type="hidden" name="make" value="{{ request()->input('make') }}">
                    <input type="hidden" name="date_from" value="{{ request()->input('date_from') }}">
                    <input type="hidden" name="date_to" value="{{ request()->input('date_to') }}">

                    <button
                        class="btn btn-sm @if(request()->input('sort_by') === 'commercial_name') btn-primary @else btn-light @endif">
                        Commercial name
                    </button>
                </form>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">KBA</div>
                <div class="card-body">
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
                                Actions
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
                                    <a href="{{ route('admin.kba.show', $dismantler) }}" class="btn btn-primary btn-sm">View</a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    {{ $germanDismantlers->links() }}
                </div>
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
