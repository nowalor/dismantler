<tr>
    <td>
        @if ($part->carPartImages->count())
            @php
                $image = $part->carPartImages()->first();
            @endphp
            <img class="card-img-bottom mt-2" src="{{ $image->original_url }}" alt="Car part image"
            style="width: 200px; height: 200px; border-radius: 12px;">
        @else
            <img class="card-img-bottom mt-2" src="https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/placeholder-car-parts.png" alt="Placeholder image" 
            style="width: 200px; height: 200px; border-radius: 12px;">
        @endif
    </td>
    <td>
        <p><span class="fw-bold">Name: </span>{{ $part->sbr_car_name }}</p>
        <p><span class="fw-bold">Quality: </span>({{  $part->quality }})</p>
        @if($part->quality == '+A')
            <p><span class="fw-bold">+A: </span>Top quality with minimal wear.</p>
        @elseif($part->quality == 'A')
            <p><span class="fw-bold">A: </span>High quality with minor wear.</p>
        @elseif($part->quality == 'A*')
            <p><span class="fw-bold">A*: </span>Above average quality.</p>
        @elseif($part->quality == 'M')
            <p><span class="fw-bold">M: </span>Moderate quality with visible wear.</p>
        @endif
    </td>
    <td>
        @if($part->original_number)
            <p>
                <span class="fw-bold">Original number: </span>
                <a href="{{ request()->fullUrlWithQuery(['filter[original_number]' => $part->original_number]) }}">
                    {{ $part->original_number }}
                </a>
            </p>
        @endif
        @if($part->article_nr)
            <p>
                <span class="fw-bold">Currus Connect ID: </span>
                <a href="{{ request()->fullUrlWithQuery(['filter[article_nr]' => $part->article_nr]) }}">
                    {{ $part->article_nr }}
                </a>
            </p>
        @endif
        @if($part->engine_type)
            <p>
                <span class="fw-bold">Engine type: </span>
                <a href="{{ request()->fullUrlWithQuery(['filter[engine_type]' => $part->engine_type]) }}">
                    {{ $part->engine_type }}
                </a>
            </p>
        @endif
        @if($part->gearbox)
            <p>
                <span class="fw-bold">Gearbox: </span>
                <a href="{{ request()->fullUrlWithQuery(['filter[gearbox]' => $part->raw_gearbox]) }}">
                    {{ $part->gearbox }}
                </a>
            </p>
        @endif
    </td>
    <td>
        <p><span class="fw-bold">Mileage: </span>{{ $part->mileage_km }}</p>
    </td>
    <td>
        <p><span class="fw-bold">Model year: </span>{{ $part->model_year }}</p>
    </td>
    <td>
        <p><span class="fw-bold">Price: </span>{{ $part->price_sek }} SEK</p>
    </td>
    <td>
        <a href="{{ route('checkout', $part) }}" class="btn btn-primary w-100">View part</a>
        <div style="margin-top: 10px; font-size: 20px; text-align: center;">
            <a href="/contact"><i class="fas fa-info-circle"></i></a>
        </div>
    </td>
</tr>
