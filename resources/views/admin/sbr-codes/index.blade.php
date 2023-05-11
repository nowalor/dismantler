@extends('app')

@section('title', 'Admin - SBR Codes')
@section('content')
    <div class="container">
        <h1 class="text-center">SBR Codes</h1>
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('admin.sbr-codes.create') }}" class="btn btn-primary">Create</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if(count($sbrCodes) > 0)
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Sbr code</th>
                            <th>Name</th>
                            <th>New code</th>
                            <th>Update code</th>
                            <th>Removed code</th>
                            <th>Remark</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sbrCodes as $sbrCode)
                            <tr>
                                <td>{{ $sbrCode->id }}</td>
                                <td>{{ $sbrCode->sbr_code }}</td>
                                <td>{{ $sbrCode->name }}</td>
                                <td>{{ $sbrCode->new_code }}</td>
                                <td>{{ $sbrCode->update_code }}</td>
                                <td>{{ $sbrCode->removed_code }}</td>
                                <td>{{ $sbrCode->remark }}</td>
                                <td>
                                    <a href="{{ route('admin.sbr-codes.show', $sbrCode->id) }}" class="btn btn-primary">View</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $sbrCodes->links() }}
                @else
                    <p>No SBR Codes found.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
