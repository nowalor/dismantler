@extends('app')
@section('title', 'Select a Brand for ' . $subCategory->name)
@section('content')

    <div class="container my-4 pt-4 bg-white rounded shadow">
        <h1 class="text-center text-primary mb-4">{{ $subCategory->name }} - Select a Brand</h1>
        <div class="row justify-content-center">
            @foreach ($brands as $brand)
                <div class="col-md-4 mb-4 d-flex justify-content-center">
                    <div class="p-3 border rounded bg-light text-center shadow-sm w-100" style="max-width: 300px;">
                        <a href="{{ route('subcategories.brands.models', [
                            'subCategoryName' => Str::slug($subCategory->name),
                            'subCategoryId' => $subCategory->id,
                            'brandName' => Str::slug($brand->name),
                            'brandId' => $brand->id,
                        ]) }}"
                            class="text-dark text-decoration-none">
                            <h5 class="mb-0">{{ $brand->name }}</h5>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
