@extends('app')
@section('title', $blog->title)

@section('content')
    <div class="container py-5">
        <div class="text-center mb-4">


            <h1 class="text-white fw-bold blog-title">{{ $blog->title }}</h1>
            <p class="text-white blog-meta">{{ __('blog-published-on') }}:
                {{ optional($blog->published_at)->format('F j, Y') }}</p>

            <!-- Display Blog Image Before the Title -->
            @if ($blog->image)
                <div class="blog-image-wrapper mb-3">
                    <img src="{{ $blog->image }}" class="blog-image" alt="{{ $blog->title }}">
                </div>
            @endif

            <!-- Blog Tags -->
            <div class="blog-tags">
                @if($blog->tags->count() > 0)
                    @foreach ($blog->tags as $tag)
                        @if(auth()->check())
                            <a href="{{ route('blogs.byTag', ['tag' => $tag->name]) }}"
                                class="badge tag-style me-1 text-decoration-none">
                                {{ $tag->name }}
                            </a>
                        @else
                            <span class="badge tag-style me-1">{{ $tag->name }}</span>
                        @endif
                    @endforeach
                @else
                    <span class="text-muted">No tags</span>
                @endif
            </div>


        </div>

        <div class="d-flex justify-content-center">
            <div class="card shadow-sm border-0 content-card">
                <div class="card-body">
                    <article target="_blank" class="fs-6 lh-base text-body">
                        {!! $blog->parsed_content !!}
                    </article>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            @if(auth()->check() && auth()->user()->is_admin)
                <a href="{{ url('/') }}" class="btn btn-secondary me-3">
                    <i class="bi bi-arrow-left"></i> Homepage
                </a>
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Blogs
                </a>
            @else
                <a href="{{ url('/') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> {{ __('back-to-homepage') }}
                </a>
            @endif
        </div>


    </div>

    <!-- Custom Styling -->
    <style>
        /* Blog Image Wrapper */
        .blog-image-wrapper {
            max-width: 700px;
            height: 350px;
            overflow: hidden;
            margin: 0 auto;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Blog Image (fixed size) */
        .blog-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Blog title */
        .blog-title {
            font-size: 2rem;
            font-weight: 600;
            color: #343a40;
            margin-top: 1rem;
        }

        /* Metadata styling */
        .blog-meta {
            font-size: 0.9rem;
            color: #6c757d;
        }

        /* Tags */
        .tag-style {
            font-size: 0.85rem;
            padding: 4px 10px;
            border-radius: 20px;
            background-color: #dee2e6;
            color: #495057;
            transition: all 0.2s ease-in-out;
        }

        .tag-style:hover {
            background-color: #28a745 !important;
            color: #ffffff !important;
            transform: scale(1.05);
        }

        /* Content Card */
        .content-card {
            max-width: 750px;
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        /* Content inside article */
        .card-body article {
            font-size: 1rem;
            line-height: 1.7;
            color: #212529;
        }
    </style>

@endsection