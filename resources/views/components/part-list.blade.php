<div style="display: flex; justify-content: space-between; align-items: center; 
    border: 1px solid #ccc; border-radius: 10px; margin: 0.5rem 0; padding: 5px; opacity: 0.95;">
    <p></p>
    <div>
        <form action="{{ $sortRoute }}" method="GET" style="display: flex;">
            <input type="text" name="search" class="form-control" placeholder="{{__("car-search-placeholder")}}" value="{{ request()->query('search') }}" style="width: 300px;">
            <button type="submit" class="btn btn-primary" style="margin-left: 5px;">{{__("car-search-button")}}</button>
        </form>
    </div>
</div>

<div class="table">
    <table class="table table-hover">
        <thead>
            <tr style="background-color:#6d6d6d; color: #dddddd;">
                <th scope="col"></th>
                <th scope="col" style="width: 20rem;">{{__("car-part-information")}}</th>
                <th scope="col">{{__("car-part-article")}}</th>
                <th scope="col">
                    @if(request()->query('sort') == 'mileage_desc')
                        <a href="{{ $sortRoute }}?sort=mileage_asc&{{ http_build_query(request()->except('sort')) }}">{{__("car-part-odometer")}} ▲</a>
                    @else
                        <a href="{{ $sortRoute }}?sort=mileage_desc&{{ http_build_query(request()->except('sort')) }}">{{__("car-part-odometer")}} ▼</a>
                    @endif
                </th>
                <th scope="col">
                    @if(request()->query('sort') == 'model_year_desc')
                        <a href="{{ $sortRoute }}?sort=model_year_asc&{{ http_build_query(request()->except('sort')) }}">{{__("car-part-modelyear")}} ▲</a>
                    @else
                        <a href="{{ $sortRoute }}?sort=model_year_desc&{{ http_build_query(request()->except('sort')) }}">{{__("car-part-modelyear")}} ▼</a>
                    @endif
                </th>
                <th scope="col">
                    <p>{{__('car-part-price')}}</p> {{-- only for now solution under this comment works. --}}
                    @if(request()->query('sort') == 'price_desc')
                        <a href="{{ $sortRoute }}?sort=price_asc&{{ http_build_query(request()->except('sort')) }}">{{__("car-part-price")}} ▲</a>
                    @else
                        <a href="{{ $sortRoute }}?sort=price_desc&{{ http_build_query(request()->except('sort')) }}">{{__("car-part-price")}} ▼</a>
                    @endif
                </th>
                <th scope="col">{{__("car-part-actions")}}</th>
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
