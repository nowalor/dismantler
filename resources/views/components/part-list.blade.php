<div style="display: flex; justify-content: flex-end; align-items: center; 
    border: 0.1rem solid #ccc; border-radius: 0.5rem; margin: 0.5rem 0; padding: 0.5rem; opacity: 0.85;">

    <!-- Dropdown with dynamic part types -->
    <div class="dropdown me-3">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            Type of Part
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li>
                <a href="{{ route('car-parts.search-by-name', array_merge(request()->query(), ['type_id' => null])) }}" class="dropdown-item">
                    All
                </a>
            </li>
            <hr>
            @foreach($partTypes as $partType)
                <li>
                    <a href="
                        @if (Route::currentRouteName() === 'car-parts.search-by-name')
                            {{ route('car-parts.search-by-name', array_merge(request()->query(), ['type_id' => $partType->id])) }}
                        @elseif (Route::currentRouteName() === 'car-parts.search-by-oem')
                            {{ route('car-parts.search-by-oem', array_merge(request()->query(), ['type_id' => $partType->id])) }}
                        @elseif (Route::currentRouteName() === 'car-parts.search-by-model')
                            {{ route('car-parts.search-by-model', array_merge(request()->query(), ['type_id' => $partType->id])) }}
                        @else
                            #
                        @endif
                        " class="dropdown-item">
                        {{ $partType->name }}
                    </a>
                </li>
                <hr>
            @endforeach
        </ul>
    </div>

    <!-- Reset Search Button -->
    <a href="/car-parts/search/by-name" class="btn btn-primary" style="padding: 0.36rem 0.8rem; font-size: 1rem; margin-right: 0.5rem;">
        Reset Search
    </a>

    <!-- Search Form -->
    <div style="display: flex;">
        <form action="{{ $sortRoute }}" method="GET" style="display: flex;">
            <input type="text" name="search" class="form-control" placeholder="{{__("car-search-placeholder")}}" 
                   value="{{ request()->query('search') }}" style="width: 20rem;">
            <button type="submit" class="btn btn-primary" style="margin-left: 0.5rem;">{{__("car-search-button")}}</button>
        </form>
    </div>
</div>



<div class="table">
    <table class="table table-hover">
        <thead>
            <tr style="background-color:#6d6d6d; color: #dddddd;">
                <th scope="col"></th>
                <th scope="col" style="width: 15rem;">{{__("car-part-information")}}</th>
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

<style>
    .table a {
        text-decoration: underline;
    }
</style>
