@extends('app')
@section('title', $blog->title)

@section('content')
    <div class="container py-5">
        <div class="text-center mb-4">


            <h1 class="text-white fw-bold blog-title">{{ $blog->title }}</h1>
            <p class="text-white blog-meta">Published on {{ optional($blog->published_at)->format('F j, Y') }}</p>

            <!-- Display Blog Image Before the Title -->
            @if ($blog->image)
                <img src="{{ $blog->image }}" class="blog-image img-fluid mb-3" alt="{{ $blog->title }}">
            @endif

            <!-- Blog Tags -->
            <div class="blog-tags">
                @if($blog->tags->count() > 0)
                    @foreach ($blog->tags as $tag)
                        <a href="{{ route('blogs.byTag', ['tag' => $tag->name]) }}"
                            class="badge tag-style me-1 text-decoration-none">
                            {{ $tag->name }}
                        </a>
                    @endforeach
                @else
                    <span class="text-muted">No tags</span>
                @endif
            </div>

        </div>

        <div class="d-flex justify-content-center">
            <div class="card shadow-sm border-0 content-card">
                <div class="card-body">
                    <article target="_blank" class="fs-5 lh-lg">
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
        /* Blog Image Styling */
        /* Blog Image Styling - Limits Size */
        .blog-image {
            width: 100%;
            max-width: 800px;
            /* Limits the width */
            height: auto;
            /* Maintains aspect ratio */
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }


        /* Blog title styling */
        .blog-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #343a40;
        }

        /* Metadata styling */
        .blog-meta {
            font-size: 1.1rem;
            color: #6c757d;
        }

        /* Tags Styling - Gray Background */
        .blog-tags {
            margin-top: 10px;
        }

        .tag-style {
            display: inline-flex;
            align-items: center;
            font-size: 0.9rem;
            padding: 5px 10px;
            background-color: #dee2e6;
            color: #495057;
            text-decoration: none;
            transition: transform 0.2s ease-in-out, background-color 0.2s ease-in-out;
        }

        /* Tag Hover Effect */
        .tag-style:hover {
            transform: scale(1.05);
            background-color: #28a745 !important;
            color: #ffffff !important;
        }

        /* Content Card Styling */
        .content-card {
            max-width: 800px;
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 10px;
        }

        /* Improve spacing and line height */
        .fs-5 {
            font-size: 1.2rem;
        }

        .lh-lg {
            line-height: 1.8;
        }
    </style>

@endsection