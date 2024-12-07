<div class="container">
    <div class="row search-controls" style="border: 0.1rem solid #ccc; border-radius: 0.5rem; margin: 0.5rem 0; padding: 0.5rem; opacity: 0.9;">
        
        <!-- Type of Part Dropdown and Sorting Dropdown (shown on small/medium views) -->
        <div class="col-12 col-md-auto d-flex justify-content-between align-items-center mb-2 mb-md-0">


<!-- Type of Part Dropdown -->
<div class="dropdown type-of-part-dropdown me-2">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"> 
        Type of Part
    </button>
    <!-- Dropdown Content -->
    <div class="dropdown-menu p-3" aria-labelledby="dropdownMenuButton" style="width: 26rem; gap: 4rem;">
      
      <!-- Main Category Column -->
      <div class="dropdown-column" id="main-category">
        <h6>Main Categories</h6>
        <ul class="list-group list-group-flush overflow-auto" style="max-height: 19rem; width: 12rem;">
            @foreach($mainCategories as $mainCategory)
            <li class="list-group-item main-category-item" data-id="{{ $mainCategory->id }}">
                {{ $mainCategory->name }}
            </li>
            @endforeach
        </ul>
    </div>
      
      <!-- Subcategory Column -->
      <div class="dropdown-column" id="sub-category">
        <h6>Sub Categories</h6>
        <ul class="list-group list-group-flush overflow-auto" style="max-height: 19rem; width: 12rem;">
          <!-- Dynamic content for subcategories -->
        </ul>
      </div>
</div>

<!-- Sorting Dropdown (visible on small/medium views) -->
</div>
        <div class="dropdown d-block d-md-none me-2">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Sort By
                </button>
                <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                    <li>
                        <a href="{{ $sortRoute }}?sort=mileage_asc&{{ http_build_query(request()->except('sort')) }}" class="dropdown-item">
                            {{__("car-part-odometer")}} ▲
                        </a>
                    </li>
                    <li>
                        <a href="{{ $sortRoute }}?sort=mileage_desc&{{ http_build_query(request()->except('sort')) }}" class="dropdown-item">
                            {{__("car-part-odometer")}} ▼
                        </a>
                    </li>
                    <li>
                        <a href="{{ $sortRoute }}?sort=model_year_asc&{{ http_build_query(request()->except('sort')) }}" class="dropdown-item">
                            {{__("car-part-modelyear")}} ▲
                        </a>
                    </li>
                    <li>
                        <a href="{{ $sortRoute }}?sort=model_year_desc&{{ http_build_query(request()->except('sort')) }}" class="dropdown-item">
                            {{__("car-part-modelyear")}} ▼
                        </a>
                    </li>
                    <li>
                        <a href="{{ $sortRoute }}?sort=price_asc&{{ http_build_query(request()->except('sort')) }}" class="dropdown-item">
                            {{__("car-part-price")}} ▲
                        </a>
                    </li>
                    <li>
                        <a href="{{ $sortRoute }}?sort=price_desc&{{ http_build_query(request()->except('sort')) }}" class="dropdown-item">
                            {{__("car-part-price")}} ▼
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Reset Search Button -->
            <a href="/car-parts/search/by-name" class="btn btn-primary" style="padding: 0.36rem 0.8rem; font-size: 1rem;">
                Reset Search
            </a>
        </div>

        {{-- search form --}}
        <div class="col-12 col-md d-flex justify-content-md-end">
            <form action="{{ $sortRoute }}" method="GET" class="w-100 w-md-auto d-flex">
                {{-- Search input --}}
                <input type="text" name="search" class="form-control" placeholder="{{__("car-search-placeholder")}}"
                       value="{{ request()->query('search') }}" style="width: 100%; max-width: 20rem;">
                
                {{-- Hidden fields to retain existing filters --}}
                <input type="hidden" name="hsn" value="{{ request()->query('hsn', $search['hsn'] ?? '') }}">
                <input type="hidden" name="tsn" value="{{ request()->query('tsn', $search['tsn'] ?? '') }}">
                <input type="hidden" name="type_id" value="{{ request()->query('type_id', $search['type_id'] ?? '') }}">
                <input type="hidden" name="dito_number_id" value="{{ request()->query('dito_number_id', $search['dito_number_id'] ?? '') }}">
                <input type="hidden" name="brand" value="{{ request()->query('brand', $search['brand'] ?? '') }}">
                <input type="hidden" name="oem" value="{{ request()->query('oem') }}">
                <input type="hidden" name="engine_code" value="{{ request()->query('engine_code') }}">
                <input type="hidden" name="gearbox" value="{{ request()->query('gearbox') }}">
                
                {{-- Submit button --}}
                <button type="submit" class="btn btn-primary" style="margin-left: 0.5rem;">{{__("car-search-button")}}</button>
            </form>
        </div>              
    </div>
</div>

<!-- parts show as table for larger screens -->
<div class="table-responsive d-none d-md-block">
    <table class="table table-hover">
        <thead>
            <tr style="background-color:#6d6d6d; color: #dddddd;">
                <th scope="col"></th>
                <th scope="col" style="width: 12rem;">{{__("car-part-information")}}</th>
                <th scope="col" style="width: 15rem;">{{__("car-part-article")}}</th>
                <th scope="col">
                    @if(request()->query('sort') == 'mileage_desc')
                        <a class="text-white" href="{{ $sortRoute }}?sort=mileage_asc&{{ http_build_query(request()->except('sort')) }}">{{__("car-part-odometer")}} ▲</a>
                    @else
                        <a class="text-white" href="{{ $sortRoute }}?sort=mileage_desc&{{ http_build_query(request()->except('sort')) }}">{{__("car-part-odometer")}} ▼</a>
                    @endif
                </th>
                <th scope="col">
                    @if(request()->query('sort') == 'model_year_desc')
                        <a class="text-white" href="{{ $sortRoute }}?sort=model_year_asc&{{ http_build_query(request()->except('sort')) }}">{{__("car-part-modelyear")}} ▲</a>
                    @else
                        <a class="text-white" href="{{ $sortRoute }}?sort=model_year_desc&{{ http_build_query(request()->except('sort')) }}">{{__("car-part-modelyear")}} ▼</a>
                    @endif
                </th>
                <th scope="col">
                    @if(request()->query('sort') == 'price_desc')
                        <a class="text-white" href="{{ $sortRoute }}?sort=price_asc&{{ http_build_query(request()->except('sort')) }}">{{__("car-part-price")}} ▲</a>
                    @else
                        <a class="text-white" href="{{ $sortRoute }}?sort=price_desc&{{ http_build_query(request()->except('sort')) }}">{{__("car-part-price")}} ▼</a>
                    @endif
                </th>
                <th scope="col"> </th>
            </tr>
        </thead>
        <tbody>
            @forelse($parts as $part)
                <x-part-item :part="$part"/>
            @empty
                <tr>
                    <td colspan="6">{{__("car-search-errormessage")}}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- table turns into cards on small views -->
<div class="d-md-none">
    @forelse($parts as $part)
    <div class="card mb-3 bg-light text-dark" style="width: 100%;">
        <div id="carousel-{{ $part->id }}" class="carousel slide bg-dark" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($part->carPartImages as $key => $image)
                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }} text-center">
                        <img src="{{ $image->logoGerman() }}" class="d-block img-fluid mx-auto" alt="Car part image" style="max-height: 200px; max-width: 100%; object-fit: contain; background-color: #000;">
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carousel-{{ $part->id }}" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel-{{ $part->id }}" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
        </div>
    
        <div class="card-body">
            <h5 class="card-title">{{ $part->sbr_car_name }} - {{ $part->carPartType->name }}</h5>
            <p class="card-text"><strong>{{ __('Original number') }}:</strong> {{ $part->original_number ?? 'N/A' }}</p>
            <p class="card-text"><strong>{{ __('Engine type') }}:</strong> {{ $part->engine_type ?? 'N/A' }}</p>
            <p class="card-text"><strong>{{ __('Gearbox') }}:</strong> {{ $part->gearbox ?? 'N/A' }}</p>
            <p class="card-text"><strong>{{ __('Mileage') }}:</strong> {{ $part->mileage_km == 0 || $part->mileage_km == 999 ? 'Unknown' : $part->mileage_km }}</p>
            <p class="card-text"><strong>{{ __('Model Year') }}:</strong> {{ $part->model_year }}</p>
            <p class="card-text"><strong>{{ __('Price') }}:</strong> {{ $part->getLocalizedPrice() }}</p>
        </div>
    
        <div class="card-body d-flex justify-content-between">
            <a href="{{ route('fullview', $part) }}" class="btn btn-primary">{{ __('View Part') }}</a>
            <a href="{{ route('contact', ['part_name' => $part->new_name, 'article_nr' => $part->article_nr]) }}" class="btn btn-primary">{{ __('Contact us') }}</a>
        </div>
    </div>
    @empty
        <p>{{__("car-search-errormessage")}}</p>
    @endforelse
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const subCategoryList = document.getElementById('sub-category').querySelector('ul');

    // Clear content of a list
    const clearList = (list) => { list.innerHTML = ''; };

    // Get current search parameters
    const currentParams = new URLSearchParams(window.location.search);

    // Add hover functionality for main categories
    document.querySelectorAll('.main-category-item').forEach(item => {
        item.addEventListener('mouseenter', function () {
            const mainCategoryId = this.getAttribute('data-id');
            clearList(subCategoryList);

            // Fetch and display subcategories for the hovered main category
            fetch(`/api/subcategories/${mainCategoryId}`)
                .then(response => response.json())
                .then(subcategories => {
                    if (!subcategories.length) {
                        subCategoryList.innerHTML = '<li class="list-group-item">No subcategories available</li>';
                        return;
                    }

                    subcategories.forEach(subcategory => {
                        const subItem = document.createElement('li');
                        subItem.classList.add('list-group-item', 'sub-category-item');
                        subItem.setAttribute('data-id', subcategory.id);

                        // Clone currentParams to avoid mutation
                        const newParams = new URLSearchParams(currentParams);
                        newParams.set('type_id', subcategory.id); // Add the type_id filter

                        subItem.innerHTML = `<a href="${window.location.pathname}?${newParams.toString()}">${subcategory.name}</a>`;
                        subCategoryList.appendChild(subItem);
                    });
                });
        });
    });
});

</script>

@push('css')
<style>
    .dropdown-menu {
        display: none;
        z-index: 1100; 
        position: absolute;
    }

    .type-of-part-dropdown:hover .dropdown-menu {
        display: flex;
    }

    .search-controls {
        position: relative;
        z-index: 1000;
    }

    .dropdown-column {
        width: 33%;
    }

    .list-group-item:hover {
        background-color: #f0f0f0;
        cursor: pointer;
    }
</style>
@endpush