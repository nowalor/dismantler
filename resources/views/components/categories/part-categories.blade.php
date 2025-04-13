<div id="car-parts-seo" class="py-10">
    <div class="container">
        <div class="text-center mt-4 mb-2">
            <h1 class="text-white">{{ __("categories") }}</h1>
        </div>
        <div class="flex justify-content-center row row-cols-1 row-cols-md-2 row-cols-lg-6 g-3">
            @foreach ($mainCategories as $mainCategory)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <a href="{{ route('categories.show', ['mainCategory' => Str::slug($mainCategory->name), 'id' => $mainCategory->id]) }}" class="text-decoration-none text-reset">

                            {{-- Image Cap with Placeholder --}}
                            <img src="{{ !empty($mainCategory->image) ? asset($mainCategory->image) : 'https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/placeholder-car-parts.png' }}"
                                 alt="{{ __("main-categories.$mainCategory->translation_key") }} image"
                                 class="card-img-top"
                                 style="width: 100%; max-height: 120px; object-fit: cover; border-bottom: 1px solid #ddd;">

                            {{-- Card Body --}}
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ __("main-categories.$mainCategory->translation_key") }}</h5>
                                <p class="card-text">{{ $mainCategory->new_car_parts_count }} {{ __('parts') }}</p>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
