@extends('app')

@section('title', 'Edit Blog')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-white fw-bold">Edit Blog</h1>
        <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Blogs
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">Title</label>
                    <input type="text" name="title" class="form-control form-control-lg" value="{{ $blog->title }}"
                        required>
                </div>

                <!-- Content -->
                <div class="mb-3">
                    <label for="content" class="form-label fw-bold">Content</label>
                    <textarea name="content" class="form-control form-control-lg" rows="6" required>
                        {{ $blog->content }}
                    </textarea>
                </div>

                <!-- Tags Input (Auto-boxing & Removal) -->
                <div class="mb-3">
                    <label for="tags" class="form-label fw-bold">Tags</label>
                    <div id="tags-container" class="form-control form-control-lg d-flex flex-wrap align-items-center">
                        @php
                            // Decode the JSON tags into an array
                            $tags = json_decode($blog->tags, true) ?? [];
                        @endphp
                        @foreach ($tags as $tag)
                            <span class="tag badge tag-style me-1 mb-1" data-value="{{ $tag }}">
                                {{ $tag }}
                                <span class="remove-tag" style="cursor: pointer;">&times;</span>
                            </span>
                        @endforeach
                        <input type="text" id="tag-input" class="border-0 flex-grow-1" placeholder="Add tags..."
                            autofocus>
                    </div>
                    <!-- Hidden field will hold the JSON array of tags -->
                    <input type="hidden" name="tags" id="hidden-tags">
                </div>

                <!-- Publish Date -->
                <div class="mb-3">
                    <label for="published_at" class="form-label fw-bold">Publish Date</label>
                    <input type="date" name="published_at" class="form-control form-control-lg"
                        value="{{ $blog->published_at->format('Y-m-d') }}" required>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="bi bi-save"></i> Update Blog
                    </button>
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

        // Collects all tag values from .tag elements
        function getAllTagValues() {
            return Array.from(tagsContainer.querySelectorAll(".tag"))
                .map(tag => tag.dataset.value);
        }

        // Updates the hidden <input> with a JSON array of tag strings
        function updateHiddenInput() {
            const tagValues = getAllTagValues();
            hiddenTags.value = JSON.stringify(tagValues);
        }

        // Creates a new .tag <span>
        function createTag(tagText) {
            const text = tagText.trim();
            if (!text) return;

            const existing = getAllTagValues();
            if (existing.includes(text)) return; // prevent duplicates

            // Build the new tag element
            const tag = document.createElement("span");
            tag.classList.add("tag", "badge", "tag-style", "me-1", "mb-1");
            tag.dataset.value = text;
            tag.innerHTML = `
                ${text}
                <span class="remove-tag" style="cursor: pointer;">&times;</span>
            `;

            // Insert before the text input
            tagsContainer.insertBefore(tag, tagInput);
            tagInput.value = "";
            updateHiddenInput();
        }

        // 1. Create a tag on Enter or comma
        tagInput.addEventListener("keydown", function (e) {
            // Enter or comma
            if (e.keyCode === 13 || e.keyCode === 188) {
                e.preventDefault();
                createTag(tagInput.value.replace(",", "").trim());
            }
        });

        // 2. Remove a tag if "×" is clicked
        tagsContainer.addEventListener("click", function (e) {
            if (e.target.classList.contains("remove-tag")) {
                e.target.parentElement.remove();
                updateHiddenInput();
            }
        });

        // 3. Remove the last tag on Backspace if input is empty
        tagInput.addEventListener("keydown", function (e) {
            if (e.keyCode === 8 && tagInput.value.trim() === "") {
                e.preventDefault();
                const allTags = tagsContainer.querySelectorAll(".tag");
                if (allTags.length > 0) {
                    allTags[allTags.length - 1].remove();
                    updateHiddenInput();
                }
            }
        });

        // Initialize the hidden field on page load
        updateHiddenInput();
    });
</script>

<!-- Custom Styling -->
<style>
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