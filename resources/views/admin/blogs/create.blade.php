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
                <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Language Dropdown -->
                    <div class="mb-3">
                        <label for="language" class="form-label fw-bold">Language</label>
                        <select name="language" class="form-select" required>
                            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <option value="{{ $localeCode }}" {{ $localeCode === app()->getLocale() ? 'selected' : '' }}>
                                    {{ Str::title($properties['native']) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Image</label>
                        <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
                        <div class="mt-3">
                            <img id="imagePreview" class="img-fluid d-none" width="200">
                        </div>
                    </div>


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

                    <!-- Tags Input (Auto-boxing & Removal) -->
                    <div class="mb-3">
                        <label for="tags" class="form-label fw-bold">Tags</label>
                        <div id="tags-container" class="form-control form-control-lg d-flex flex-wrap align-items-center">
                            <input type="text" id="tag-input" class="border-0 flex-grow-1" placeholder="Add tags...">
                        </div>
                        <!-- Hidden field to store the final tag list -->
                        <input type="hidden" name="tags" id="hidden-tags">
                    </div>

                    <!-- Publish Date -->
                    <div class="mb-3">
                        <label for="published_at" class="form-label">Publish Date</label>
                        <input type="date" name="published_at" class="form-control" required>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-success">Create Blog</button>
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-danger">Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        // image preview
        document.addEventListener("DOMContentLoaded", function () {
            const imageInput = document.getElementById("imageInput");
            const imagePreview = document.getElementById("imagePreview");

            imageInput.addEventListener("change", function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        imagePreview.src = event.target.result;
                        imagePreview.classList.remove("d-none");
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.src = "";
                    imagePreview.classList.add("d-none");
                }
            });

            // tag boxing and stuff
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

        // date picker in input field
        document.addEventListener("DOMContentLoaded", function () {
            const dateInput = document.querySelector('input[name="published_at"]');

            dateInput.addEventListener("focus", function () {
                this.showPicker();
            });
        });
    </script>

    <style>
        #imagePreview {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 10px;
        }

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

        .card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }

        .btn {
            border-radius: 6px;
            padding: 10px 15px;
            font-size: 1rem;
        }
    </style>
@endsection