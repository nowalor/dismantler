@extends('app')

@section('title', 'Blogs')

@section('content')
<div class="container py-4">
    <h2 class="text-dark fw-bold mb-4">All Blogs</h2>

    <!-- Tag Filter Notice -->
    @if(isset($filter))
        <div class="alert alert-info">
            {{ $filter }}
            <a href="{{ route('blogs.index') }}" class="btn btn-sm btn-outline-primary ms-2">Clear Filter</a>
        </div>
    @endif

    <!-- Blog List -->
    <div class="row">
        @forelse ($blogs as $blog)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold text-dark">{{ $blog->title }}</h5>
                        <p class="text-muted small">
                            {{ Str::limit(strip_tags($blog->content), 100, '...') }}
                            <a href="{{ route('blogs.show', $blog->id) }}" class="text-success fw-bold">Read more</a>
                        </p>

                        <!-- Tags -->
                        <p class="mb-1"><strong>Tags:</strong>
                            @foreach ($blog->tags as $tag)
                                <a href="{{ route('blogs.tags', $tag->name) }}"
                                    class="badge bg-info text-dark">{{ $tag->name }}</a>
                            @endforeach
                        </p>

                        <!-- Publish Date -->
                        <p class="mb-1"><strong>Published:</strong> {{ optional($blog->published_at)->format('Y-m-d') }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p>No blogs found.</p>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $blogs->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection