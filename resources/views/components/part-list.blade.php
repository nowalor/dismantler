<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 10px; margin-top: 10px; padding: 5px;">
    <p></p>
    <div>
        <form action="{{ route('car-parts.search') }}" method="GET" style="display: flex;">
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
                        <a href="{{ route('car-parts.search-by-model', ['sort' => 'mileage_asc'] + request()->query()) }}">Odometer (KM) ▲</a>
                    @else
                        <a href="{{ route('car-parts.search-by-model', ['sort' => 'mileage_desc'] + request()->query()) }}">Odometer (KM) ▼</a>
                    @endif
                </th>
                <th scope="col">
                    @if(request()->query('sort') == 'model_year_desc')
                        <a href="{{ route('car-parts.search-by-model', ['sort' => 'model_year_asc'] + request()->query()) }}">Model Year ▲</a>
                    @else
                        <a href="{{ route('car-parts.search-by-model', ['sort' => 'model_year_desc'] + request()->query()) }}">Model Year ▼</a>
                    @endif
                </th>
                <th scope="col">
                    @if(request()->query('sort') == 'price_desc')
                        <a href="{{ route('car-parts.search-by-model', ['sort' => 'price_asc'] + request()->query()) }}">Price ▲</a>
                    @else
                        <a href="{{ route('car-parts.search-by-model', ['sort' => 'price_desc'] + request()->query()) }}">Price ▼</a>
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