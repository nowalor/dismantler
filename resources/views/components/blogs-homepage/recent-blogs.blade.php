<div class="container py-5 position-relative recent-blogs-section">
    <h2 class="text-center text-white mb-5">{{ __('recent-blogs') }}</h2>

    <div id="recentBlogsCarousel" class="carousel slide" data-bs-ride="false">
        <div class="carousel-inner">
            @foreach($recentBlogs->chunk(3) as $chunkIndex => $chunk)
                <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                    <div class="row g-4 px-3">
                        @foreach($chunk as $blog)
                            <div class="col-md-4 d-flex">
                                <div class="card blog-card shadow border-0 w-100">
                                    @if($blog->image)
                                        <img src="{{ $blog->image }}" class="card-img-top blog-img" alt="{{ $blog->title }}">
                                    @else
                                        <div class="blog-img d-flex align-items-center justify-content-center bg-light text-muted">
                                            {{ __('blog-no-image') }}
                                        </div>
                                    @endif

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $blog->title }}</h5>
                                        <p class="card-text text-muted mb-1">{{ $blog->formatted_published_at }}</p>
                                        <div class="mb-2">
                                            @foreach($blog->tags as $tag)
                                                <span class="badge bg-secondary">{{ $tag->name }}</span>
                                            @endforeach
                                        </div>
                                        <p class="card-text flex-grow-1">
                                            {!! Str::limit(strip_tags($blog->parsed_content), 100) !!}
                                        </p>
                                        <a href="{{ route('blogs.show', $blog->id) }}"
                                            class="btn btn-primary mt-auto">{{ __('read-more-blogs') }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        @if($recentBlogs->count() > 3)
            <button class="carousel-control-prev" type="button" data-bs-target="#recentBlogsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#recentBlogsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        @endif
    </div>
</div>

<style>
    /* Scope all styling within .recent-blogs-section so it doesn't affect other parts */
    .recent-blogs-section .blog-card {
        min-height: 500px;
        display: flex;
        flex-direction: column;
    }

    .recent-blogs-section .blog-img {
        height: 220px;
        object-fit: cover;
        border-bottom: 1px solid #ddd;
    }

    .recent-blogs-section .carousel-inner {
        padding-bottom: 2rem;
    }

    /* Position your arrows outside the cards */
    .recent-blogs-section .carousel-control-prev,
    .recent-blogs-section .carousel-control-next {
        top: 50%;
        transform: translateY(-50%);
        width: auto;
        height: auto;
        z-index: 2;
    }

    .recent-blogs-section .carousel-control-prev {
        left: -3rem;
    }

    .recent-blogs-section .carousel-control-next {
        right: -3rem;
    }

    /* Make only the buttons in this section use the success (green) variant */
    .recent-blogs-section .btn.btn-primary {
        background-color: var(--bs-success) !important;
        border-color: var(--bs-success) !important;
        color: #fff !important;
    }

    .recent-blogs-section .btn.btn-primary:hover {
        background-color: #218838 !important;
        /* Slightly darker green on hover */
        border-color: #1e7e34 !important;
    }
</style>