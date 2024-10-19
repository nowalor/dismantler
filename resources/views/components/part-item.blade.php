<tr>
    <td>
        @if ($part->carPartImages->count())
        <div id="partImagesCarousel-{{ $part->id }}" class="carousel slide mt-2" data-bs-ride="carousel" style="width: 100%; max-width: 20rem; border-radius: 0.7rem;">

            <!-- Indicators -->
        <div class="carousel-indicators">
            @foreach($part->carPartImages as $key => $image)
                <button type="button" data-bs-target="#partImagesCarousel-{{ $part->id }}" data-bs-slide-to="{{ $key }}" 
                        class="{{ $key === 0 ? 'active' : '' }}" aria-current="{{ $key === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $key + 1 }}"></button>
            @endforeach
        </div>

            <div class="carousel-inner">
                @foreach($part->carPartImages as $key => $image)
                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                        <!-- Make the image responsive using img-fluid -->
                        <img src="{{ $image->logoGerman() }}" class="d-block w-100 img-fluid" alt="Car part image" style="border-radius: 0.7rem; object-fit: cover;">
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#partImagesCarousel-{{ $part->id }}" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#partImagesCarousel-{{ $part->id }}" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
        </div>
    @else
        <img class="card-img-bottom mt-2 img-fluid" src="https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/placeholder-car-parts.png" alt="Placeholder image" 
            style="width: 100%; max-width: 25rem; border-radius: 0.7rem; object-fit: cover;">
    @endif
    </td>
    <td class="text-white">
        <p><span class="fw-bold"> </span>{{ $part->sbr_car_name }} <br> {{ $part->carPartType->name }}</p>     
    </td>
    <td class="text-white">
        @if($part->original_number)
            <p>
                <span class="fw-bold">{{__('car-part-original')}}: </span>
                <a href="{{ request()->fullUrlWithQuery(['filter[original_number]' => $part->original_number]) }}" class="text-white">
                    {{ $part->original_number }}
                </a>
            </p>
        @endif
        @if($part->article_nr)
            <p>
                <span class="fw-bold">Currus Connect ID: </span>
                <a href="{{ request()->fullUrlWithQuery(['filter[article_nr]' => $part->article_nr]) }}" class="text-white">
                    {{ $part->article_nr }}
                </a>
            </p>
        @endif
        @if($part->engine_type)
            <p>
                <span class="fw-bold">{{__('car-part-engine-type')}}: </span>
                <a href="{{ request()->fullUrlWithQuery(['filter[engine_type]' => $part->engine_type]) }}" class="text-white">
                    {{ $part->engine_type }}
                </a>
            </p>
        @endif
        @if($part->gearbox)
            <p>
                <span class="fw-bold">{{__('car-info-gearbox')}}: </span>
                <a href="{{ request()->fullUrlWithQuery(['filter[gearbox]' => $part->raw_gearbox]) }}" class="text-white">
                    {{ $part->gearbox }}
                </a>
            </p>
        @endif
        <p class="pb-0"><span class="fw-bold">{{__('car-info-quality')}}: </span>
            @if($part->quality == 'A+')
                {{__('car-quality-A+')}}
            @elseif($part->quality == 'A')
                {{__('car-quality-A')}}
            @elseif($part->quality == 'A*')
                {{__('car-quality-A*')}}
            @elseif($part->quality == 'M')
                {{__('car-quality-M')}}
            @endif
        </p>
    </td>
    <td class="text-white">
        @php
        use Illuminate\Support\Str;
            $swedishDismantlerCodes = ['F', 'A', 'AL', 'D', 'LI', 'W'];
            $danishDismantlerCodes = []; // soon to come as we only have swedish dismantlers atm
        @endphp

        @if ($part->mileage_km === "0" || $part->mileage_km === "999" && Str::contains($part->article_nr, $swedishDismantlerCodes))
            <p><span class="fw-bold">{{__('car-part-mileage')}}: </span> Unknown</p>
        @else
            <p><span class="fw-bold">{{__('car-part-mileage')}}: </span>{{ $part->mileage_km }}</p>
        @endif
    </td>
    <td class="text-white">
        <p><span class="fw-bold">{{__("car-part-modelyear")}}: </span>{{ $part->model_year }}</p>
    </td>
    <td class="text-white">
        <p><span class="fw-bold">{{ __('car-part-price') }}: </span>{{ $part->getLocalizedPrice() }}</p>
    </td>
    <td>
        <a href="{{ route('fullview', $part) }}" class="btn btn-primary w-100 mb-2">{{__('car-view-part')}}</a>
        <a href="{{ route('contact', ['part_name' => $part->new_name, 'article_nr' => $part->article_nr]) }}" class="btn btn-primary w-100 mb-2">
            {{__('contact-us')}}
        </a>
    </td>
</tr>
