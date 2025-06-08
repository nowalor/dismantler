<div class="col-md-6 pt-2">
    <div class="card shadow-sm mb-2">
        <div class="card-body">
            @isset($cardTitle)
                <h6 class="pb-2">{{ $cardTitle }}</h6>
            @endisset
            @if ($carPart->carPartImages->count())
                @php
                    $images = $carPart->carPartImages;
                    $firstImage = $images->first();
                    $otherImages = $images->skip(1);
                @endphp
                <!-- Large Image Display -->
                <img class="img-fluid rounded mb-2" src="{{ $firstImage->logoGerman() }}"
                    alt="{{ $carPart->pageTitle() }}" style="max-width: 100%; border-radius: 1rem;">
            @else
                <img class="img-fluid rounded mb-4"
                    src="https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/placeholder-car-parts.png"
                    alt="{{ $carPart->pageTitle() }}" style="max-width: 100%; border-radius: 1rem;">
            @endif
            <h3 class="fw-bold large-text">{{ $carPart->sbr_car_name }}</h3>
            <h4 class="text-primary large-text">
                {{ $carPart->full_price }}  @if(!$carPart->getLocalizedPrice()['requires_request'])
                {{ $carPart->getLocalizedPrice()['symbol'] }} @endif
                @if(!$carPart->getLocalizedPrice()['requires_request'])
                    <span>{{ __('vat-shipping') }}</span>
                    <a href="javascript:void(0);" onclick="showInfoPopup()">
                        <i class="fas fa-info-circle ml-2"></i>
                    </a>
                @endif
            </h4>
            <!--Pop up message-->
            @include('components.pop-up', [
                'title' => __('vat-infoTitle'),
                'message' => __('vat-infoDescription'),
                'closeButton' => __('pop-up-close'),
                'contactButton' => __('pop-up-contact'),
            ])

            <a href="{{ route('checkout', $carPart) }}" class="btn btn-primary w-100 mb-2">
                {{ __('pop-up-buy-now') }}
            </a>
            <a href="{{ route('fullview', $carPart) }}" class="btn btn-primary w-100 mb-2">
                {{ __('car-view-part') }}
            </a>
            <a href="{{ route('contact', ['part_name' => $carPart->new_name, 'article_nr' => $carPart->article_nr]) }}" class="btn btn-primary w-100 mb-4">
                {{ __('contact-us') }}
            </a>

            <p><span class="fw-bold">Currus Connect ID: </span>{{ $carPart->article_nr }}</p>
            <p><span class="fw-bold">{{ __('type-of-spare') }}: </span>{{ __('used-part') }}</p>
            <p><span class="fw-bold">{{ __('car-part-engine-type') }}: </span>{{ $carPart->engine_type }}</p>
            <p><span class="fw-bold">{{ __('car-info-gearbox') }}: </span>{{ $carPart->gearbox_nr }}</p>
            <p><span class="fw-bold">{{ __('car-info-quality') }}: </span>{{ $carPart->quality }}</p>
            @if ($carPart->quality == 'A+')
                <p><strong>A+ </strong>{{ __('car-quality-A+') }}</p>
            @elseif($carPart->quality == 'A')
                <p><strong>A </strong>{{ __('car-quality-A') }}</p>
            @elseif($carPart->quality == 'A*')
                <p><strong>A* </strong>{{ __('car-quality-A*') }}</p>
            @elseif($carPart->quality == 'M')
                <p><strong>M </strong>{{ __('car-quality-M') }}</p>
            @endif
            <p><span class="fw-bold">{{ __('car-part-original') }}: </span>
                <a href=" {{ route('car-parts.search-by-oem', $carPart->original_number) }}">{{ $carPart->original_number }}</a>
            </p>
            <p><span class="fw-bold">{{ __('chassi-nr') }}: </span> {{ $carPart->vin }} </p>
            <p><span class="fw-bold">KBA:</span> {{ $carPart->kba_number }}</p>
            <p><span class="fw-bold">{{ __('car-part-modelyear') }}: </span>{{ $carPart->model_year }}</p>
            <p><span class="fw-bold">{{ __('car-part-mileage') }}:</span>
                @if ($carPart->mileage_km === '0')
                    <strong>{{ __('unknown-message') }}</strong>
                @else
                    {{ $carPart->mileage_km }} KM
            @endif
            <p><span class="fw-bold">{{ __('fuel-type') }}: </span>{{ $carPart->fuel }}</p>
        </div>
    </div>
</div>
