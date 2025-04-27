@extends('app')

@section('title', 'Admin - Newsletter')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="col-12 pt-4 text-white">
            <h5>Select view</h5>
            <div class="d-flex gap-2 pt-2 pb-2">
                <a href="{{ route('admin.newsletter.index', ['type' => 'new']) }}" class="btn btn-primary"
                    id="show-main-categories">New</a>
                <a href="{{ route('admin.newsletter.index', ['type' => 'all']) }}" class="btn btn-primary"
                    id="show-main-categories">All</a>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between w-100 align-items-center">
                    <p class="mb-0">Newsletter signees</p>
                    @if(!$showAll)
                        <form method="POST" action="{{ route('admin.newsletter.mark-as-seen') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" id="show-main-categories">Mark all as
                                seen</button>
                        </form>
                    @endif
                </div>

                <div class="card-body" id="categories-display">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th># ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($signees as $signee)
                                <tr>
                                    <td>{{ $signee->id }}</td>
                                    <td>{{ $signee->name }}</td>
                                    <td>{{ $signee->email }}</td>
                                    <td>
                                        @if($signee->seen_at)
                                            <span class="badge bg-info">Old</span>
                                        @else
                                            <span class="badge bg-danger">New</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.newsletter.delete', $signee->id) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this signee?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($signees->isEmpty())
                        <div class="text-center py-4">
                            <p>No signees found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection