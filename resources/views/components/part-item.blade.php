<tr>
    <td>
        @if ($part->carPartImages->count())
            @php
                $image = $part->carPartImages()->first();
            @endphp
            <img class="card-img-bottom mt-2" src="{{ $image->original_url }}" alt="Car part image"
            style="width: 200px; height: 200px;">
        @else
            <img class="card-img-bottom mt-2" src="https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/placeholder-car-parts.png" alt="Placeholder image" 
            style="width: 200px; height: 200px;">
        @endif
    </td>
    <td>
        <p><span class="fw-bold">Name: </span>{{ $part->new_name }}</p>
        <p><span class="fw-bold">Type: </span>{{ $part->carPartType->name }}</p>
        <p><span class="fw-bold">Article number: </span>{{ $part->article_nr }}</p>
        <p><span class="fw-bold">Original number: </span>{{ $part->original_number }}</p>
        <p><span class="fw-bold">Fuel: </span>{{ $part->fuel }}</p>
        <p><span class="fw-bold">Engine type: </span>{{ $part->engine_type }}</p>
        <p><span class="fw-bold">Gearbox: </span>{{ $part->subgroup ?? $part->gearbox }}</p>
    </td>
    <td>
        <p><span class="fw-bold">Article number: </span>{{ $part->article_nr }}</p>
        <p><span class="fw-bold">Original number: </span>notYet</p>
        <p><span class="fw-bold">Vin: </span>{{ $part->vin }}</p>
        <p><span class="fw-bold">Engine code: </span>{{ $part->engine_code }}</p>
        <p><span class="fw-bold">Gearbox code: </span>notYet</p>
    </td>
    <td>
        <p><span class="fw-bold"></span>{{ $part->mileage_km }}</p>
    </td>
    <td>
        <p><span class="fw-bold"></span>{{ $part->model_year }}</p>
    </td>
    <td>
        <p><span class="fw-bold"></span>({{  $part->quality }})</p>
    </td>
    <td>
        <p><span class="fw-bold"></span>{{ $part->price_sek }} SEK</p>
    </td>
    <td>
        <a href="{{ route('checkout', $part) }}" class="btn btn-primary w-100">View part</a>
    </td>
</tr>


