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
        <p><span class="fw-bold">{{__('car-info-name')}}: </span>{{ $part->new_name }}</p>
        <p><span class="fw-bold">{{__('car-info-quality')}}: </span>{{ $part->quality }}</p>
            @if($part->quality == 'A+')
                <p><strong>A+ </strong>{{__('car-quality-A+')}}</p>
            @elseif($part->quality == 'A')
                <p><strong>A </strong>{{__('car-quality-A')}}</p>
            @elseif($part->quality == 'A*')
                <p><strong>A* </strong>{{__('car-quality-A*')}}</p>
            @elseif($part->quality == 'M')
                <p><strong>M </strong>{{__('car-quality-M')}}</p>
            @endif
    </td>
    <td>
        @if($part->original_number)
            <p>
                <span class="fw-bold">{{__('car-part-original')}}: </span>
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
                <span class="fw-bold">{{__('car-part-engine-type')}}: </span>
                <a href="{{ request()->fullUrlWithQuery(['filter[engine_type]' => $part->engine_type]) }}">
                    {{ $part->engine_type }}
                </a>
            </p>
        @endif
        @if($part->gearbox)
            <p>
                <span class="fw-bold">{{__('car-info-gearbox')}}: </span>
                <a href="{{ request()->fullUrlWithQuery(['filter[gearbox]' => $part->raw_gearbox]) }}">
                    {{ $part->gearbox }}
                </a>
            </p>
        @endif
    </td>
    <td>
        <p><span class="fw-bold">{{__('car-part-mileage')}}: </span>{{ $part->mileage_km }}</p>
    </td>
    <td>
        <p><span class="fw-bold">{{__("car-part-modelyear")}}: </span>{{ $part->model_year }}</p>
    </td>
    <td>
        <p><span class="fw-bold">{{__('car-part-price')}}: </span>{{ $part->price_sek }} SEK</p>
    </td>
    <td>
        <a href="{{ route('fullview', $part) }}" class="btn btn-primary w-100 mb-2">{{__('car-view-part')}}</a>
        <a href="{{ route('checkout', $part) }}" class="btn btn-primary w-100">{{__('car-checkout')}}</a>
        <div style="margin-top: 20px; font-size: 20px; text-align: center;">
            <a href="/contact"><i class="fas fa-info-circle"></i></a>
        </div>
    </td>
</tr>
