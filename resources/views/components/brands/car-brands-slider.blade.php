@props(['brands'])

<div id="car-brand-seo" class="pb-4">
    <div class="d-flex justify-content-center align-items-center mt-3 text-white">
        <h1>{{ __('brands') }}</h1>
    </div>
    <div class="d-flex justify-content-center">
        <ul id="brand-list" class="d-flex list-unstyled flex-wrap p-2">
            @foreach ($brands as $index => $brand)
                <li class="brand-item {{ $index >= 7 ? 'd-none' : '' }} p-2 bg-white rounded">
                    <a href="{{ route('brands.models', ['brand' => $brand]) }}" style="text-decoration: none;">
                        <img src="{{ $brand->image }}" alt="{{ $brand->name }} brand logo" class="img-fluid"
                             style="width: 11rem; height: 8.2rem; object-fit: contain; border: 1px solid #ddd;">
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="d-flex justify-content-center mt-3">
        <button type="button" class="btn btn-light" id="load-more">{{ __("Models") }}</button>
    </div>
</div>

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
