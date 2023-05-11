@extends('app')
@section('title', "ADMIN - {$ditoNumber->producer} {$ditoNumber->brand} - SBR CODES")
@section('content')
    <div class="container">
        @if(session()->has('error'))
            <div class="alert alert-danger mt-4 pt-2 col-6">
                {{ session()->get('error') }}
            </div>
        @endif
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
                        Selected Dito number
                        <div>
                            <a href="{{ route('admin.dito-numbers.show', $ditoNumber->id - 1) }}"
                               class="btn btn-primary btn-sm"><-Prev</a>
                            <a href="{{ route('admin.dito-numbers.show', $ditoNumber->id + 1) }}"
                               class="btn btn-primary btn-sm">Next-></a>
                            <a href="{{ route('admin.dito-numbers.index') }}" class="btn btn-success btn-sm">All</a>
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
                    <div class="card-header">Selected SBR codes</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>SBR code</th>
                                <th>Name</th>
                                <th>New code</th>
                                <th>Update code</th>
                                <th>Removed Code</th>
                                <th>Remark</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ditoNumber->sbrCodes as $sbrCode)
                                <tr>
                                    <th>{{ $sbrCode->id }}</th>
                                    <th>{{ $sbrCode->sbr_code }}</th>
                                    <td>{{ $sbrCode->name }}</td>
                                    <td>{{ $sbrCode->new_code }}</td>
                                    <td>{{ $sbrCode->update_code }}</td>
                                    <td>{{ $sbrCode->removed_code }}</td>
                                    <td>{{ $sbrCode->remark }}</td>
                                    <td>
                                        <form
                                            action="{{ route('admin.dito-numbers.sbr-codes.destroy', [$ditoNumber, $sbrCode]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Remove</button>
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

        <div class="col-4">
            <form action="{{ route('admin.dito-numbers.sbr-codes.index', $ditoNumber) }}">
                <label for="sbr-codes-search">Search</label>
                <input name="search" type="text" id="sbr-codes-search" class="form-control mb-2" value="{{ request()->get('search') }}">
                <button class="btn btn-primary">
                    Submit
                </button>
            </form>
        </div>
        <div class="col-12 mx-auto pt-4">
            <form method="POST" action="{{ route('admin.dito-numbers.sbr-codes.store', $ditoNumber) }}">
                @csrf
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Select SBR CODES
                        <button class="btn btn-primary btn-sm">Save selected</button>

                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>SBR code</th>
                                <th>Name</th>
                                <th>New code</th>
                                <th>Update code</th>
                                <th>Removed Code</th>
                                <th>Remark</th>
                                <th>
                                    <div class="btn btn-primary btn-info text-white" id="select-all-sbr-button">Select
                                        all on page
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sbrCodes as $sbrCode)
                                <tr>
                                    <th>{{ $sbrCode->id }}</th>
                                    <th>{{ $sbrCode->sbr_code }}</th>
                                    <td>{{ $sbrCode->name }}</td>
                                    <td>{{ $sbrCode->new_code }}</td>
                                    <td>{{ $sbrCode->update_code }}</td>
                                    <td>{{ $sbrCode->removed_code }}</td>
                                    <td>{{ $sbrCode->remark }}</td>
                                    <td>
                                        <label id="sbr_code_checkboxes">Select</label>
                                        <input name="sbr_code_checkboxes[]" class="form-check-input" type="checkbox"
                                               id="sbr_code_checkboxes" value="{{ $sbrCode->id }}"
                                        >
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $sbrCodes->links() }}
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        const selectAllBtn = document.getElementById('select-all-sbr-button')
        const checkBoxes = document.getElementsByName('sbr_code_checkboxes[]')

        function handleSelectAll() {
            checkBoxes.forEach(checkbox => checkbox.checked = true)
        }

        selectAllBtn.addEventListener('click', handleSelectAll)
    </script>
@endsection
