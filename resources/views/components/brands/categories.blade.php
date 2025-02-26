@extends('app')

@section('title', __('parts-for') . ' ' . $brand->name . ' - ' . $model->new_name)

@section('content')
<div class="container my-4 pt-4 bg-white rounded shadow">
    <h1 class="text-center text-primary mb-4">
        {{ __('parts-for') }} {{ $brand->name }} - {{ $model->new_name }}
    </h1>

    <div class="row justify-content-center">
        @forelse ($mainCategories as $mainCategory)
            <div class="col-md-6 mb-4">
                <div class="p-3 border rounded bg-light shadow-sm">
                    {{-- Main Category Name --}}
                    <h5 class="text-dark">{{ $mainCategory->name }}</h5>

                    <ul class="list-group list-group-flush">
                        @forelse ($mainCategory->carPartTypes as $subCategory)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{-- Subcategory Link with Part Count --}}
                                <a href="{{ route('car-parts.search-by-model', [
                                    'dito_number_id' => $model->id,
                                    'type_id' => $subCategory->id
                                ]) }}" class="text-decoration-none text-dark">
                                    {{ $subCategory->name }}
                                </a>
                                <span class="badge bg-secondary">
                                    {{ $subCategory->part_count ?? 0 }}
                                </span>
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
@endsection
