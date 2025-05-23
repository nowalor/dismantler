<form action="{{ route('search-by-plate') }}" method="POST">
    @csrf
    <label>Licence plate / vin*</label>
    <br/>
    <input type="text" name="search">
    <br/>
    <div class="d-flex">
        <div>
            <label for="plate">Number plate</label>
            <input id="plate" type="radio" name="search_by" value="plate" checked>
        </div>

        <div>
            <label for="vin">VIN</label>
            <input id="vin" type="radio" name="search_by" value="vin">
        </div>
    </div>
    <button>Submit</button>
</form>

<div style="display: flex; gap: 45px;">
    <div style="width: 500px;">
        @if(isset($filteredCarParts))
            <h1>Car part results</h1>
            @foreach($filteredCarParts as $carPart)
                <h3>{{ $carPart->new_name }}</h3>
                <h3>{{ $carPart->article_nr }}</h3>
                <p>engine code: {{ $carPart->engine_code}}</p>
                @if(count($carPart->carPartImages ))
                    <img src="{{  $carPart->carPartImages[0]->original_url }}" alt="Image of car part" style="width: 400px;">
                @endif
            @endforeach
        @endif

        @if(isset($matchingPartsWithDifferentEngine))
            <h1>Car part with different engine</h1>
            @foreach($matchingPartsWithDifferentEngine as $carPart)
                <h3>{{ $carPart->new_name }}</h3>
                <h3>{{ $carPart->article_nr }}</h3>
                <p>engine code: {{ $carPart->engine_code}}</p>
                @if(count($carPart->carPartImages ))
                    <img src="{{  $carPart->carPartImages[0]->original_url }}" alt="Image of car part" style="width: 400px;">
                @endif
            @endforeach
        @endif
    </div>

    @if(isset($data))
        <div style="width: 500px;">
            <h1>Results from API</h1>

            @foreach($data as $key=>$value)
                @if(gettype($value) !== 'array')
                    <p><span style="font-weight:bold;">{{ $key }}: </span> {{ $value }}</p>
                @endif
            @endforeach
        </div>
    @endif
</div>

