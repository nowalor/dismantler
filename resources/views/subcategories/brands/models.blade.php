@extends('app')
@section('title', 'Select a Model for ' . $brand->name)
@section('content')

<div class="container my-4 pt-4 bg-white rounded shadow">
    <h1 class="text-center text-primary mb-4">{{ $brand->name }} - Select a Model</h1>
    <div class="row justify-content-center">
        @foreach ($models as $model)
            <div class="col-md-4 mb-4 d-flex justify-content-center">
                <div class="p-3 border rounded bg-light text-center shadow-sm w-100" style="max-width: 300px;">
                    <a href="{{ route('subcategories.brands.models.search', ['subCategoryId' => $subCategory->id, 'brandId' => $brand->id, 'modelId' => $model->id]) }}" class="text-dark text-decoration-none">
                        <h5 class="mb-0">{{ $model->new_name }}</h5>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
