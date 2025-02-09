@extends('app')
@section('title', $blog->title)

@section('content')
<div class="container py-5">
    <div class="text-center mb-4">
        <h1 class="text-white fw-bold blog-title">{{ $blog->title }}</h1>
        <p class="text-white blog-meta">Published on {{ optional($blog->published_at)->format('F j, Y') }}</p>

        <!-- Blog Tags (Now Gray) -->
        <div class="blog-tags">
            @php
                $tags = json_decode($blog->tags, true);
            @endphp
            @if(is_array($tags))
                @foreach ($tags as $tag)
                    <span class="badge tag-style me-1">{{ $tag }}</span>
                @endforeach
            @else
                <span class="badge tag-style">{{ $blog->tags }}</span>
            @endif
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="card shadow-sm border-0 content-card">
            <div class="card-body">
                <article class="fs-5 lh-lg">
                    {!! nl2br(e($blog->content)) !!}
                </article>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Blogs
        </a>
    </div>
</div>

<!-- Custom Styling -->
<style>
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
        /* Soft gray */
        color: #495057;
        /* Darker text */
        border-radius: 4px;
        /* Less rounded */
        border: 1px solid #ced4da;
        /* Light border */
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