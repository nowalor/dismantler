<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 10px; margin-top: 10px; padding: 5px;">
    <p></p>
    <div>
        <form action="{{ $sortRoute }}" method="GET" style="display: flex;">
            <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request()->query('search') }}" style="width: 300px;">
            <button type="submit" class="btn btn-primary" style="margin-left: 5px;">Search</button>
        </form>
    </div>
</div>

<div class="table">
    <table class="table table-hover">
        <thead>
            <tr style="background-color:#b3b2b2; color: #000000;">
                <th scope="col"></th>
                <th scope="col">Part Information</th>
                <th scope="col">Article Number</th>
                <th scope="col">
                    @if(request()->query('sort') == 'mileage_desc')
                        <a href="{{ $sortRoute }}?sort=mileage_asc&{{ http_build_query(request()->except('sort')) }}">Odometer (KM) ▲</a>
                    @else
                        <a href="{{ $sortRoute }}?sort=mileage_desc&{{ http_build_query(request()->except('sort')) }}">Odometer (KM) ▼</a>
                    @endif
                </th>
                <th scope="col">
                    @if(request()->query('sort') == 'model_year_desc')
                        <a href="{{ $sortRoute }}?sort=model_year_asc&{{ http_build_query(request()->except('sort')) }}">Model Year ▲</a>
                    @else
                        <a href="{{ $sortRoute }}?sort=model_year_desc&{{ http_build_query(request()->except('sort')) }}">Model Year ▼</a>
                    @endif
                </th>
                <th scope="col">
                    @if(request()->query('sort') == 'price_desc')
                        <a href="{{ $sortRoute }}?sort=price_asc&{{ http_build_query(request()->except('sort')) }}">Price ▲</a>
                    @else
                        <a href="{{ $sortRoute }}?sort=price_desc&{{ http_build_query(request()->except('sort')) }}">Price ▼</a>
                    @endif
                </th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($parts as $part)
                <x-part-item :part="$part"/>
            @empty
                <tr>
                    <td colspan="6">No parts were found matching this query</td>
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
