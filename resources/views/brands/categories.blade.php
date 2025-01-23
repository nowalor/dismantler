@extends('app')

@section('title', 'Parts for ' . $brand->name . ' - ' . $model->new_name)

@section('content')
<div class="container my-4 pt-4 bg-white rounded shadow">
    <h1 class="text-center text-primary mb-4">
        Parts for {{ $model->new_name }}
    </h1>

    <div class="row justify-content-center">
        @forelse ($mainCategories as $mainCategory)
            <div class="col-md-6 mb-4">
                <div class="p-3 border rounded bg-light shadow-sm">
                    {{-- Main Category Name --}}
                    <h5 class="text-dark">{{ $mainCategory->name }}</h5>

                    <ul class="list-group list-group-flush">
                        @forelse ($mainCategory->carPartTypes as $subCategory)
                            <li class="list-group-item">

                                {{-- Subcategory Name + Part Count --}}
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>
                                        {{ $subCategory->name }}
                                        <span class="badge bg-secondary">
                                            {{ $subCategory->part_count ?? 0 }}
                                        </span>
                                    </span>

                                    {{-- Expand/Collapse Button --}}
                                    @if(($subCategory->part_count ?? 0) > 0)
                                        <button class="btn btn-sm btn-outline-primary"
                                                onclick="togglePartsList({{ $subCategory->id }})">
                                            Show Parts
                                        </button>
                                    @endif
                                </div>

                                {{-- Actual Parts List (Hidden by default) --}}
                                @if(($subCategory->part_count ?? 0) > 0)
                                    <ul id="subCategory-{{ $subCategory->id }}"
                                        class="list-group list-group-flush mt-2 d-none">
                                        @foreach($subCategory->parts as $part)
                                            <li class="list-group-item">
                                                {{--
                                                    Display part info and/or link directly to a detailed page
                                                    or your existing "search-by-model" route
                                                --}}
                                                <a href="{{ route('car-parts.search-by-model', [
                                                    'dito_number_id' => $model->id,
                                                    'type_id' => $subCategory->id
                                                ]) }}" class="text-decoration-none text-dark">
                                                    {{ $part->name }} (ID: {{ $part->id }})
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                            </li>
                        @empty
                            <li class="list-group-item text-muted">
                                No subcategories available
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        @empty
            <p class="text-muted">No categories available for this model.</p>
        @endforelse
    </div>
</div>

{{-- Simple JavaScript for Toggling Part Lists --}}
<script>
    function togglePartsList(subCategoryId) {
        const element = document.getElementById(`subCategory-${subCategoryId}`);
        if (element.classList.contains('d-none')) {
            element.classList.remove('d-none');
        } else {
            element.classList.add('d-none');
        }
    }
</script>
@endsection
