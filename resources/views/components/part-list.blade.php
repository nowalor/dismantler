<div class="container">
    <div class="row search-controls" style="border: 0.1rem solid #ccc; border-radius: 0.5rem; margin: 0.5rem 0; padding: 0.5rem; opacity: 0.9;">
        
        <!-- Type of Part Dropdown and Sorting Dropdown (shown on small/medium views) -->
        <div class="col-12 col-md-auto d-flex justify-content-between align-items-center mb-2 mb-md-0">
            <!-- Type of Part Dropdown -->
            <div class="dropdown me-2">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Type of Part
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li>
                        <a href="{{ route('car-parts.search-by-name', array_merge(request()->query(), ['type_id' => null])) }}" class="dropdown-item py-1 px-2">
                            All
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    @foreach($partTypes as $partType)
                    <li>
                        <a href="
                            @if (Route::currentRouteName() === 'car-parts.search-by-name')
                                {{ route('car-parts.search-by-name', array_merge(request()->query(), ['type_id' => $partType->id])) }}
                            @elseif (Route::currentRouteName() === 'car-parts.search-by-oem')
                                {{ route('car-parts.search-by-oem', array_merge(request()->query(), ['type_id' => $partType->id])) }}
                            @elseif (Route::currentRouteName() === 'car-parts.search-by-model')
                                {{ route('car-parts.search-by-model', array_merge(request()->query(), ['type_id' => $partType->id])) }}
                            @elseif (Route::currentRouteName() === 'car-parts.search-by-code')
                                {{ route('car-parts.search-by-code', array_merge(request()->query(), ['type_id' => $partType->id])) }}
                            @else
                                #
                            @endif
                            " class="dropdown-item py-1 px-2">
                            {{ __('part-types.' . $partType->name) ?? $partType->name }}
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    @endforeach
                </ul>
            </div>
            

            <!-- Sorting Dropdown (visible on small/medium views) -->
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
                        <img src="{{ $image->original_url }}" class="d-block img-fluid mx-auto" alt="Car part image" style="max-height: 200px; max-width: 100%; object-fit: contain; background-color: #000;">
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

@push('css')
<style>
    .dropdown-menu {
        z-index: 1050; 
    }

    .search-controls {
        position: relative;
        z-index: 1000;
    }
</style>
@endpush