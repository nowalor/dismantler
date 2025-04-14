@extends('app')

@section('title', 'Edit Blog')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-white fw-bold">Edit Blog</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Language Dropdown -->
                    <div class="mb-3">
                        <label for="language" class="form-label fw-bold">Language</label>
                        <select name="language" class="form-select" required>
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $lang)
                                <option value="{{ $localeCode }}" {{ $blog->language === $localeCode ? 'selected' : '' }}>
                                    {{ Str::title($lang['native']) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">Upload New Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">

                        <!-- Show Current Image -->
                        @if ($blog->image)
                            <div class="mt-2">
                                <img src="{{ $blog->image }}" class="blog-image-preview img-fluid" width="150">
                            </div>
                        @endif
                    </div>

                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Title</label>
                        <input type="text" name="title" class="form-control form-control-lg" value="{{ $blog->title }}"
                            required>
                    </div>

                    <!-- Content -->
                    <div class="mb-3">
                        <label for="content" class="form-label fw-bold">Content</label>
                        <textarea name="content" class="form-control form-control-lg" rows="6"
                            required>{{ old('content', $blog->content) }}</textarea>
                    </div>

                    <!-- Tags Input -->
                    <div class="mb-3">
                        <label for="tags" class="form-label fw-bold">Tags</label>
                        <div id="tags-container" class="form-control form-control-lg d-flex flex-wrap align-items-center">
                            @if($blog->tags && $blog->tags->count() > 0)
                                @foreach ($blog->tags as $tag)
                                    <span class="tag badge tag-style me-1 mb-1" data-value="{{ $tag->name }}">
                                        {{ $tag->name }}
                                        <span class="remove-tag" style="cursor: pointer;">&times;</span>
                                    </span>
                                @endforeach
                            @endif
                            <input type="text" id="tag-input" class="border-0 flex-grow-1" placeholder="Add tags...">
                        </div>
                        <input type="hidden" name="tags" id="hidden-tags"
                            value="{{ old('tags', isset($blog->tags) && $blog->tags->isNotEmpty() ? $blog->tags->pluck('name')->implode(', ') : '') }}">
                    </div>

                    <!-- Publish Date -->
                    <div class="mb-3">
                        <label for="published_at" class="form-label fw-bold">Publish Date</label>
                        <input type="date" name="published_at" class="form-control form-control-lg"
                            value="{{ old('published_at', $blog->formatted_published_at ?? '') }}">
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> Update Blog
                        </button>
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-danger">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for Auto-Boxing & Removing Tags -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tagInput = document.getElementById("tag-input");
            const tagsContainer = document.getElementById("tags-container");
            const hiddenTags = document.getElementById("hidden-tags");

            function updateHiddenInput() {
                const tags = Array.from(tagsContainer.querySelectorAll(".tag")).map(tag => tag.dataset.value);
                hiddenTags.value = tags.join(', ');
            }

            function createTag(tagText) {
                const text = tagText.trim();
                if (!text || getAllTagValues().includes(text)) return;

                const tag = document.createElement("span");
                tag.classList.add("tag", "badge", "tag-style", "me-1", "mb-1");
                tag.dataset.value = text;
                tag.innerHTML = `${text} <span class="remove-tag" style="cursor: pointer;">&times;</span>`;

                tagsContainer.insertBefore(tag, tagInput);
                tagInput.value = "";
                updateHiddenInput();
            }

            function getAllTagValues() {
                return Array.from(tagsContainer.querySelectorAll(".tag")).map(tag => tag.dataset.value);
            }

            tagInput.addEventListener("keydown", function (e) {
                if (e.key === "Enter" || e.key === ",") {
                    e.preventDefault();
                    createTag(tagInput.value.replace(",", "").trim());
                }
            });

            tagsContainer.addEventListener("click", function (e) {
                if (e.target.classList.contains("remove-tag")) {
                    e.target.parentElement.remove();
                    updateHiddenInput();
                }
            });

            updateHiddenInput();
        });

        // image change in new image upload
        document.addEventListener("DOMContentLoaded", function () {
            const imageInput = document.querySelector('input[name="image"]');
            const previewImage = document.querySelector('.blog-image-preview');

            imageInput.addEventListener("change", function (event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImage.src = e.target.result; // Updates the preview with the new image
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

    </script>

    <!-- Custom Styling -->
    <style>
        /* Blog Image Preview Styling */
        .blog-image-preview {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 10px;
        }

        /* Tags input field styling */
        #tags-container {
            min-height: 50px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 8px;
        }

        #tag-input {
            outline: none;
            font-size: 1rem;
            flex-grow: 1;
            min-width: 120px;
            border: none;
        }

        .tag-style {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            font-size: 0.9rem;
            background-color: #dee2e6 !important;
            color: #495057;
            border-radius: 4px;
            border: 1px solid #ced4da;
        }

        .remove-tag {
            font-size: 1rem;
            font-weight: bold;
            color: #dc3545;
            margin-left: 5px;
            cursor: pointer;
        }

        /* Card Styling */
        .card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }

        /* Button Enhancements */
        .btn {
            border-radius: 6px;
            padding: 10px 15px;
            font-size: 1rem;
        }
    </style>
@endsection