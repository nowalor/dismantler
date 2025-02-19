<div id="car-parts-seo" class="py-10">
    <div class="container">
        <div class="text-center mt-4 mb-2">
            <h1 class="text-white">Categories</h1>
        </div>
        <div class="row bg-white border rounded pl-2 pr-2 pt-2 pb-2" style="border: 2px solid #ddd;">
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
