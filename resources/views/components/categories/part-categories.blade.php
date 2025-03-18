<div id="car-parts-seo" class="py-10">
    <div class="container">
        <div class="text-center mt-4 mb-2">
            <h1 class="text-white">{{ __("categories") }}</h1>
        </div>
        <div class="row bg-white border rounded pl-2 pr-2 pt-2 pb-2" style="border: 2px solid #ddd;">
            @foreach ($mainCategories as $mainCategory)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <a href="{{ route('categories.show', ['mainCategory' => Str::slug($mainCategory->name), 'id' => $mainCategory->id]) }}" class="text-decoration-none text-reset">
                            <div class="card-body text-center">
                                @if(!empty($mainCategory->image))
                                    <img src="{{ asset($mainCategory->image) }}"
                                         alt="{{ __("main-categories.$mainCategory->translation_key") }} image"
                                         class="img-fluid mb-3"
                                         style="width: 100%; max-height: 150px; object-fit: contain; border: 1px solid #ddd;">
                                @endif
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
