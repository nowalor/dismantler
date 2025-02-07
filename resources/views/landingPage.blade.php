@extends('app')
@section('title', 'Currus-connect.com: ' . __('page-titles.home'))
@section('content')

@php
    /* the "/" in some of the category names creating parsing issues with the
    will create a slug for maincategories / carPartTypes instead of using category->name*/
    use Illuminate\Support\Str;
@endphp


    <div class="cta">
        <div class="d-flex justify-content-center text-center mx-auto pt-4">
            <img src="{{ asset($logoPath) }}" style="max-width: 25rem; max-height: 40rem;" class="pt-2"
                alt="{{ __('alt-tags.homepage_logo_2') }}" title="{{ $logo['title'] ?? 'Currus Connect' }}">
        </div>

        <div class="d-flex justify-content-center align-items-center mt-3">
            <div class="text-center">
                {{--  <a href="/car-parts/search/by-name?search=" class="fw-semibold btn btn-success">{{ __('browse')}}</a> --}}
            </div>
        </div>

        <livewire:search-forms />
    </div>

    <div id="car-brand-seo">
        <div class="d-flex justify-content-center align-items-center mt-3 text-white">
            <h1>Brands</h1>
        </div>
        <div class="d-flex justify-content-center">
            <ul id="brand-list" class="d-flex list-unstyled flex-wrap p-2">
                @foreach ($brands as $index => $brand)
                    <li class="brand-item {{ $index >= 7 ? 'd-none' : '' }} p-2 bg-white rounded">
                        <a href="{{ route('brands.models', ['slug' => $brand->slug]) }}" style="text-decoration: none;">
                            <img src="{{ $brand->image }}" alt="{{ $brand->name }} brand logo" class="img-fluid"
                                style="width: 11rem; height: 8.2rem; object-fit: contain; border: 1px solid #ddd;">
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <button type="button" class="btn btn-light" id="load-more">Click to view more car brands</button>
        </div>
    </div>

    <hr class="my-4" style="height: 4px; border: none; background-color: #ddd;">

    <div id="car-parts-seo" class="py-8">
        <div class="container">
            <div class="text-center mt-4 mb-2">
                <h1 class="text-white">Categories</h1>
            </div>
            <div class="row bg-white border rounded p-4" style="border: 2px solid #ddd;">
                @foreach ($mainCategories as $category)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            <a href="{{ route('categories.show', ['name' => Str::slug($category->name), 'id' => $category->id]) }}" class="text-decoration-none text-reset">
                                <div class="card-body text-center">
                                    @if(!empty($category->image))
                                        <img src="{{ asset($category->image) }}"
                                             alt="{{ $category->name }} image"
                                             class="img-fluid mb-3"
                                             style="width: 100%; max-height: 150px; object-fit: contain; border: 1px solid #ddd;">
                                    @endif
                                    <h5 class="card-title">{{ $category->name }}</h5>
                                    <p class="card-text">{{ $category->new_car_parts_count }} parts</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Question for Nikulas: Why can't I pass the $brands data into my component? --}}
    {{-- <x-car-brands-slider :brands="$brands">
        </x-car-brands-slider> --}}

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadMoreButton = document.getElementById('load-more');
        const brandItems = Array.from(document.querySelectorAll('.brand-item'));
        let visibleCount = 7; // Initially visible items

        loadMoreButton.addEventListener('click', function() {
            const nextItems = brandItems.slice(visibleCount, visibleCount + 67);
            nextItems.forEach(item => item.classList.remove('d-none'));

            // Update the count of visible items
            visibleCount += 67;

            // Hide the button if all items are visible
            if (visibleCount >= brandItems.length) {
                loadMoreButton.style.display = 'none';
            }
        });
    });
</script>

<style>
    #brand-list {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1rem;
        max-width: calc(7 * 12rem);
        /* Adjust width for 7 items per row */
    }

    .brand-item {
        width: 11rem;
        /* Ensure consistent size */
        height: auto;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 0.5rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
