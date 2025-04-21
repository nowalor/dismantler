@if($recentBlogs->isNotEmpty())
<div class="container py-5 position-relative">
    <h2 class="text-center text-white display-5 fw-semibold mb-5">{{ __('recent-blogs') }}</h2>

    <div id="recentBlogsCarousel" class="carousel slide" data-bs-ride="false">
        <div class="carousel-inner">
            @foreach($recentBlogs->chunk(3) as $chunkIndex => $chunk)
                <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                    <div class="row g-4 px-3 justify-content-center">
                        @foreach($chunk as $blog)
                            <div class="col-md-4 d-flex">
                                <div class="card blog-card shadow-sm border-0 w-100 h-100 rounded-4">
                                    @if($blog->image)
                                        <img src="{{ $blog->image }}" class="card-img-top blog-img" alt="{{ $blog->title }}">
                                    @else
                                        <div class="blog-img d-flex align-items-center justify-content-center bg-light text-muted fw-medium">
                                            {{ __('blog-no-image') }}
                                        </div>
                                    @endif

                                    <div class="card-body d-flex flex-column p-4">
                                        <h5 class="card-title fw-semibold fs-5 mb-1">{{ $blog->title }}</h5>

                                        <p class="card-text flex-grow-1 text-body small mb-3"
                                           title="{{ strip_tags($blog->parsed_content) }}">
                                            {{ Str::limit(strip_tags($blog->parsed_content), 300, '...') }}
                                        </p>

                                        <div class="mb-3">
                                            @foreach($blog->tags as $tag)
                                                <span class="badge rounded-pill bg-secondary small me-1">{{ $tag->name }}</span>
                                            @endforeach
                                        </div>

                                        <p class="card-text text-muted text-end small fw-light mb-2">
                                            {{-- <i class="bi bi-calendar"></i> --}}
                                            📅 {{ optional($blog->published_at)->format('d.m.Y') }}
                                        </p>

                                        <a href="{{ route('blogs.show', $blog->id) }}"
                                           class="btn btn-primary mt-auto w-100 rounded-pill">
                                            {{ __('read-more-blogs') }}
                                        </a>
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
                <span class="carousel-control-prev-icon custom-arrow" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#recentBlogsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon custom-arrow" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        @endif
    </div>
</div>
@endif
<style>
    .blog-card {
        border-radius: 1rem;
        overflow: hidden;
    }

    .blog-img {
        height: 220px;
        object-fit: cover;
        width: 100%;
    }

    .blog-img:not(img) {
        height: 220px;
        font-size: 1rem;
        text-align: center;
    }

    .carousel-inner {
        padding-bottom: 2rem;
    }

    .carousel-control-prev,
    .carousel-control-next {
        top: 50%;
        transform: translateY(-50%);
        width: 3rem;
        height: 3rem;
        z-index: 2;
    }

    .carousel-control-prev {
        left: -2.5rem;
    }

    .carousel-control-next {
        right: -2.5rem;
    }

    .custom-arrow {
        background-color: rgba(0, 0, 0, 0.6);
        border-radius: 50%;
        padding: 0.75rem;
        background-size: 70%;
    }

    .btn.btn-primary {
        background-color: var(--bs-success) !important;
        border-color: var(--bs-success) !important;
        color: #fff !important;
    }

    .btn.btn-primary:hover {
        background-color: #218838 !important;
        border-color: #1e7e34 !important;
    }

    .badge.bg-secondary {
        background-color: #6c757d;
    }
</style>
