@extends('app')
@section('title', 'Search')
@section('content')
    <div class="table">
        <table class="table table-hover">
            <thead>
                <tr style="background-color:#b3b2b2; color: #000000;">
                    <th scope="col">Name</th>
                    <th scope="col">Article Number</th>
                    <th scope="col">Odometer (KM)</th>
                    <th scope="col">Model Year</th>
     {{--               <th scope="col">Price</th>--}}
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($parts as $part)
                    <tr>
                        <td>{{ $part->name }}</td>
                        <td>{{ $part->article_nr }}</td>
                        <td>{{ $part->mileage_km }}</td>
                        <td>{{ $part->model_year }}</td>
    {{--                    <td>{{ $part->price3 }}</td>--}}
                        <td>
                            <a href="{{ route('fullview', ['part' => $part->id]) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No parts were found matching this query</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $parts->links() }} <!-- Pagination links -->
    </div>
@endsection
