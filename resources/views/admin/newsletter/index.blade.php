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
                <a href="{{ route('admin.newsletter.index', ['type' => 'new']) }}" class="btn btn-success">New</a>
                <a href="{{ route('admin.newsletter.index', ['type' => 'all']) }}" class="btn btn-primary">All</a>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between w-100 align-items-center">
                    <p class="mb-0">Newsletter signees</p>
                    @if(!$showAll)
                        <form method="POST" action="{{ route('admin.newsletter.mark-as-seen') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Mark all as seen</button>
                        </form>
                    @endif
                </div>

                <div class="card-body">

                    <form method="GET" action="{{ route('admin.newsletter.index') }}" class="d-flex flex-wrap gap-2 mb-3">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                            placeholder="Search by name or email">
                        <input type="hidden" name="type" value="{{ $showAll ? 'all' : 'new' }}">
                        <input type="hidden" name="sort_by" value="{{ $sortBy }}">
                        <input type="hidden" name="sort_order" value="{{ $sortOrder }}">
                        <button type="submit" class="btn btn-secondary">Search</button>
                        <a href="{{ route('admin.newsletter.index', ['type' => $showAll ? 'all' : 'new']) }}"
                            class="btn btn-outline-secondary">Clear</a>
                    </form>

                    @php
                        function sortLink($label, $field, $sortBy, $sortOrder, $showAll)
                        {
                            $newOrder = ($sortBy === $field && $sortOrder === 'asc') ? 'desc' : 'asc';
                            $params = array_merge(request()->all(), [
                                'sort_by' => $field,
                                'sort_order' => $newOrder,
                                'type' => $showAll ? 'all' : 'new',
                            ]);
                            $url = route('admin.newsletter.index', $params);
                            $arrow = ($sortBy === $field) ? ($sortOrder === 'asc' ? ' ↑' : ' ↓') : '';
                            return "<a href=\"{$url}\" class=\"text-decoration-none\">{$label}{$arrow}</a>";
                        }
                    @endphp

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{!! sortLink('# ID', 'id', $sortBy, $sortOrder, $showAll) !!}</th>
                                <th>{!! sortLink('Name', 'name', $sortBy, $sortOrder, $showAll) !!}</th>
                                <th>{!! sortLink('Email', 'email', $sortBy, $sortOrder, $showAll) !!}</th>
                                <th>{!! sortLink('Status', 'status', $sortBy, $sortOrder, $showAll) !!}</th>
                                <th>{!! sortLink('Created At', 'created_at', $sortBy, $sortOrder, $showAll) !!}</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($signees as $signee)
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
                                    <td>{{ $signee->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.newsletter.destroy', $signee) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this signee?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No signees found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center">
                        {{ $signees->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection