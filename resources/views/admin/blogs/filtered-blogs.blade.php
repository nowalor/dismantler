@extends('app')
@section('title', "Blogs Tagged: $tagName")

@section('content')
    <div class="container py-5">
        <!-- Blog Header & Search -->
        <div class="text-center mb-4">
            <h2 class="fw-bold text-white">Tag: <span class="badge bg-success">{{ $tagName }}</span></h2>

            <!-- Search Bar -->
            <div class="search-container mt-3">
                <input id="search-bar" type="text" name="search" value="{{ request('search') }}"
                    class="form-control search-bar" placeholder="Search blogs...">
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-4">
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-light btn-lg shadow-sm back-button">
                <i class="bi bi-arrow-left"></i> Back to All Blogs
            </a>
        </div>

        <!-- Blog List -->
        <div id="blog-container" class="row justify-content-center mt-4">
            <div id="blog-list" class="col-md-8">
                @forelse ($blogs as $blog)
                    <div class="card blog-card shadow-sm mb-4">
                        <div class="card-body">
                            <h4 class="fw-bold text-dark">{{ $blog->title }}</h4>

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
                            <p class="mb-2"><strong>Tags:</strong>
                                @foreach ($blog->tags as $tag)
                                    <a href="{{ route('blogs.byTag', ['tag' => $tag->name]) }}" class="badge tag-style me-1">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </p>

                            <!-- Publish Date -->
                            <p class="mb-2"><strong>Published:</strong> {{ optional($blog->published_at)->format('Y-m-d') }}</p>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-center gap-3 mt-3">
                                <a href="{{ route('admin.blogs.show', $blog->id) }}" class="btn btn-success">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted">No blogs found with this tag.</p>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {!! $blogs->appends(request()->except('page'))->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>

    <!-- AJAX Script for Live Search & Pagination -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchBar = document.getElementById('search-bar');
            const blogContainer = document.getElementById('blog-container');
            let searchTimer;

            function fetchBlogs(searchTerm, page = 1) {
                let url;

                // ✅ Detect if we are on the tag-filtered page or the blog dashboard
                if (window.location.pathname.includes('/tags/')) {
                    // We are on a tag-filtered page (filtered_blogs.blade.php)
                    url = "{{ request()->routeIs('blogs.byTag') ? route('blogs.byTag', ['tag' => $tagName ?? '']) : route('admin.blogs.index') }}?";
                } else {
                    // We are on the main dashboard (index.blade.php)
                    url = "{{ route('admin.blogs.index') }}?";
                }

                if (searchTerm) {
                    url += 'search=' + encodeURIComponent(searchTerm) + '&';
                }
                url += 'page=' + page;

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                    .then(response => response.json()) // Expect JSON response
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

            // Live search
            searchBar.addEventListener('input', function () {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    fetchBlogs(searchBar.value, 1);
                }, 500);
            });

            // Intercept pagination link clicks
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

    <!-- Styling -->
    <style>
        /* Centering everything */
        .container {
            max-width: 900px;
        }

        /* Search Bar */
        .search-container {
            display: flex;
            justify-content: center;
        }

        .search-bar {
            max-width: 400px;
            padding: 12px;
            border-radius: 30px;
            border: 1px solid #ced4da;
            font-size: 1rem;
            text-align: center;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-bar:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0px 2px 6px rgba(0, 123, 255, 0.3);
        }

        /* Back Button */
        .back-button {
            display: inline-block;
            margin-bottom: 30px;
            /* Added space to separate from cards */
            border-radius: 30px;
            padding: 12px 24px;
            font-size: 1.1rem;
            font-weight: bold;
            color: #333;
            background-color: #f8f9fa;
            border: 2px solid #495057;
            transition: all 0.3s ease-in-out;
        }

        .back-button:hover {
            background-color: #e0e0e0;
            color: #000;
            border-color: #000;
        }

        /* Blog Cards */
        .blog-card {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 20px;
            width: 100%;
            text-align: center;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .blog-card:hover {
            transform: scale(1.03);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Tag Styling (Gray Background & No Underline) */
        .tag-style {
            font-size: 0.9rem;
            padding: 5px 10px;
            background-color: #dee2e6;
            /* Gray background */
            color: #495057;
            border-radius: 4px;
            border: 1px solid #ced4da;
            text-decoration: none;
            /* No underline */
            display: inline-block;
            transition: transform 0.2s ease-in-out, background-color 0.2s ease-in-out;
        }

        /* Tag Hover Effect */
        .tag-style:hover {
            transform: scale(1.05);
            background-color: #28a745 !important;
            /* Green hover effect */
            color: #ffffff !important;
        }

        /* Buttons */
        .btn {
            border-radius: 8px;
            font-size: 1rem;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .search-bar {
                width: 100%;
                max-width: 100%;
            }

            .blog-card {
                width: 100%;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
@endsection