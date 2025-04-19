@extends('app')
@section('title', 'Blog Dashboard')

@section('content')
    <div class="container py-4">
        <!-- Blog Dashboard Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 blog-header">
            <h2 class="text-white fw-bold mb-3 mb-md-0">Dashboard</h2>

            <!-- Tools: Language, Search & Create -->
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <!-- Language Filter -->
                <form method="GET" id="language-filter-form" class="m-0">
                    <select name="lang" onchange="document.getElementById('language-filter-form').submit()"
                        class="form-select form-select-sm" style="width: 140px; font-size: 0.85rem;">
                        <option value="">All Languages</option>
                        @foreach(LaravelLocalization::getSupportedLocales() as $code => $lang)
                            <option value="{{ $code }}" {{ request('lang') === $code ? 'selected' : '' }}>
                                {{ Str::title($lang['native']) }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <!-- Search -->
                <input id="search-bar" type="text" name="search" value="{{ request('search') }}"
                    class="form-control search-bar" placeholder="Search blogs...">

                <!-- Create Blog -->
                <a href="{{ route('admin.blogs.create') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-plus-lg"></i> Create Blog
                </a>
            </div>
        </div>

        <!-- Flash Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tag Filter Header -->
        @if(request('tag'))
            <div class="d-flex justify-content-center">
                <div class="alert alert-info d-inline-flex align-items-center p-2">
                    <span class="text-dark fw-bold mb-0 d-flex align-items-center">Filtering by tag:</span>
                    <span class="badge bg-success px-3 py-1 ms-1 d-flex align-items-center"
                        style="position: relative; top: 2px;">
                        {{ request('tag') }}
                    </span>
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-danger px-3 py-1 fw-bold ms-3">Clear filter</a>
                </div>
            </div>
        @endif

        <!-- Blog List Container (Dynamically Updated by AJAX) -->
        <div id="blog-container">
            <div id="blog-list">
                @forelse ($blogs as $blog)
                    <div class="card blog-card mb-3">
                        <div class="card-body">
                            <h5 class="fw-bold text-dark blog-title">{{ $blog->title }}</h5>
                            @if ($blog->image)
                                <div class="text-center mb-3">
                                    <img src="{{ $blog->image }}" class="blog-image img-fluid rounded"
                                        style="max-width: 80%; height: auto;">
                                </div>
                            @endif

                            <!-- Limited Content Preview -->
                            <div class="blog-content text-muted small">
                                {!! Str::limit($blog->parsed_content, 250, '...') !!}
                                <a href="{{ route('admin.blogs.show', $blog->id) }}" class="text-success fw-bold">Read more</a>
                            </div>

                            <!-- Tags -->
                            <p class="mb-1"><strong>Tags:</strong>
                                <span class="blog-tags">
                                    @if ($blog->tags->count() > 0)
                                        @foreach ($blog->tags as $tag)
                                            <a href="{{ route('admin.blogs.index', ['tag' => $tag->name]) }}"
                                                class="badge tag-style me-1 text-decoration-none">
                                                {{ $tag->name }}
                                            </a>
                                        @endforeach
                                    @else
                                        <span class="text-muted">No tags</span>
                                    @endif
                                </span>
                            </p>

                            <p class="mb-1"><strong>Publish Date:</strong>
                                {{ optional($blog->published_at)->format('Y-m-d') }}
                            </p>

                            <p class="mb-1"><strong>Status:</strong>
                                @if ($blog->published_at > now())
                                    <span class="badge bg-warning text-dark">Upcoming</span>
                                @else
                                    <span class="badge bg-success">Published</span>
                                @endif
                            </p>

                            <p class="mb-1"><strong>Language:</strong>
                                <span class="badge bg-secondary text-uppercase">
                                    {{ $blog->language }}
                                </span>
                            </p>
                            <!-- Actions -->
                            <div class="mt-3 d-flex flex-wrap gap-2">
                                <a href="{{ route('admin.blogs.show', $blog->id) }}" class="btn btn-success btn-sm">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-danger">No blogs found</p>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $blogs->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- AJAX for Live Search & Tag Filtering -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchBar = document.getElementById('search-bar');
            const blogContainer = document.getElementById('blog-container');
            let searchTimer;

            function fetchBlogs(searchTerm, page = 1) {
                let url = "{{ route('admin.blogs.index') }}?";

                if (searchTerm) {
                    url += 'search=' + encodeURIComponent(searchTerm) + '&';
                }

                if (window.location.search.includes('tag=')) {
                    const tag = new URLSearchParams(window.location.search).get('tag');
                    url += 'tag=' + encodeURIComponent(tag) + '&';
                }

                url += 'page=' + page;

                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(response => response.json())
                    .then(data => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(data.html, 'text/html');
                        const newBlogContainer = doc.querySelector('#blog-container');

                        if (newBlogContainer) {
                            blogContainer.innerHTML = newBlogContainer.innerHTML;
                        }

                        rebindPaginationLinks();
                    })
                    .catch(error => console.error('Error fetching blogs:', error));
            }

            searchBar.addEventListener('input', function () {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    fetchBlogs(searchBar.value, 1);
                }, 500);
            });

            function rebindPaginationLinks() {
                const paginationLinks = blogContainer.querySelectorAll('.pagination a');
                paginationLinks.forEach(link => {
                    link.addEventListener('click', function (event) {
                        event.preventDefault();
                        const url = new URL(link.href);
                        const page = url.searchParams.get('page') || 1;
                        fetchBlogs(searchBar.value, page);
                    });
                });
            }

            rebindPaginationLinks();
        });
    </script>

    <style>
        /* Blog Header */
        .blog-header {
            max-width: 700px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Search Bar Styling */
        .search-bar {
            width: 200px;
            padding: 6px;
            border-radius: 5px;
            border: 1px solid #ced4da;
            font-size: 0.9rem;
        }

        /* Blog Card Styling */
        .blog-card {
            border-radius: 10px;
            background-color: #ffffff;
            padding: 20px;
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Tag Styling (Default) */
        .tag-style {
            font-size: 0.8rem;
            /* Keeps default small size */
            padding: 5px 10px;
            /* Keeps it compact */
            background-color: #dee2e6;
            color: #495057;
            display: inline-block;
            text-decoration: none;
            /* Removes underline */
            transition: transform 0.2s ease-in-out, background-color 0.2s ease-in-out;
        }

        /* Tag Hover Effect */
        .tag-style:hover {
            transform: scale(1.05);
            /* Small zoom effect */
            background-color: #28a745 !important;
            /* Changes to green */
            color: #ffffff !important;
        }


        /* Buttons */
        .btn-sm {
            font-size: 0.8rem;
            padding: 6px 10px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .d-flex.flex-column.flex-md-row {
                flex-direction: column !important;
                text-align: center;
            }

            .search-bar {
                width: 100%;
                max-width: 100%;
            }

            .btn-sm {
                width: 100%;
                text-align: center;
            }

            .d-flex.align-items-center {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
@endsection