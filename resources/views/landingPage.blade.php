@extends('app')
@section('title', 'Currus-connect.com: ' . __('page-titles.home'))
@section('content')

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

    <div class="d-flex justify-content-center align-items-center mt-3 text-white">
        <h1>Car Brands</h1>
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
            // Show 14 more items
            const nextItems = brandItems.slice(visibleCount, visibleCount + 14);
            nextItems.forEach(item => item.classList.remove('d-none'));

            // Update the count of visible items
            visibleCount += 14;

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
        margin: 0 auto;
        padding: 0;
    }

    .brand-item {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 0.5rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
