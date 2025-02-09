@extends('app')
@section('title', 'Create Blog')

@section('content')
<div class="container pt-2">
    <h1 class="text-white pt-4">Create New Blog</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.blogs.store') }}" method="POST">
                @csrf

                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter blog title" required>
                </div>

                <!-- Content -->
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" class="form-control" rows="5" placeholder="Enter blog content"
                        required></textarea>
                </div>

                <!-- Tags -->
                <div class="mb-3">
                    <label for="tags" class="form-label">Tags (comma separated)</label>
                    <input type="text" name="tags" class="form-control" placeholder="Enter tags">
                </div>

                <!-- Publish Date -->
                <div class="mb-3">
                    <label for="published_at" class="form-label">Publish Date</label>
                    <input type="date" name="published_at" class="form-control" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Create Blog</button>
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Back to Blogs</a>
            </form>
        </div>
    </div>
</div>
@endsection