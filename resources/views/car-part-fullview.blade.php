@extends('app')
@section('title', $part->pageTitle())
@section('content')
    <div id="fullview-container" class="container pt-2 pb-3 pl-4 pr-4">
        @if($breadcrumbs)
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-left">
                    @foreach ($breadcrumbs as $breadcrumb)
                        @if ($loop->last)
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $part->new_name ?? $breadcrumb['name'] }}
                            </li>
                        @else
                            <li class="breadcrumb-item">
                                <a href="{{ $breadcrumb['route'] }}">
                                    {{ $breadcrumb['name'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        @endif
        <h1 class="large-text font-bold">{{ $part->pageTitle() }}</h1>
        <div class="row">
            <!-- Product Image Gallery -->
            <div class="col-md-6 text-center pt-2">
                <div class="card shadow-sm">
                    <div class="card-body">
                        @if ($part->carPartImages->count())
                            @php
                                $images = $part->carPartImages;
                                $firstImage = $images->first();
                                $otherImages = $images->skip(1); // Skip the first image and take the rest
                            @endphp
                                    <!-- Large Image Display -->
                            <img id="mainImage" class="img-fluid rounded mb-2" src="{{ $firstImage->logoGerman() }}"
                                 alt="{{ $part->pageTitle() }}" style="max-width: 100%; border-radius: 1rem;">

                            <!-- Thumbnail Images -->
                            <div class="row justify-content-center">
                                <div class="d-flex flex-wrap justify-content-center">
                                    @foreach ($images as $image)
                                        <div class="p-1 thumb-container">
                                            <img class="img-thumbnail thumb" src="{{ $image->logoGerman() }}"
                                                 alt="Thumbnail {{ $loop->iteration }}"
                                                 style="width: 100%; cursor: pointer;"
                                                 onclick="changeImage('{{ $image->logoGerman() }}')">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <img class="img-fluid rounded mb-4"
                                 src="https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/placeholder-car-parts.png"
                                 alt="{{ $part->pageTitle() }}" style="max-width: 100%; border-radius: 1rem;">
                        @endif
                    </div>
                </div>
            </div>

            <!-- Product Information -->
            <div class="col-md-6 pt-2">
                <div class="card shadow-sm mb-2">
                    <div class="card-body">
                        <h3 class="fw-bold large-text">{{ $part->sbr_car_name }}</h3>
                        <h4 class="text-primary large-text">
                            {{ $part->full_price }}  @if(!$part->getLocalizedPrice()['requires_request'])
                            {{ $part->getLocalizedPrice()['symbol'] }} @endif
                            @if(!$part->getLocalizedPrice()['requires_request'])
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

                                <a href="{{ route('checkout', $part) }}"
                                   class="btn btn-primary w-100 mt-4 mb-2">
                                    {{ __('pop-up-buy-now') }}
                                </a>
                        <a href="{{ route('contact', ['part_name' => $part->new_name, 'article_nr' => $part->article_nr]) }}"
                           class="btn btn-primary w-100 mb-4">
                            {{ __('contact-us') }}
                        </a>
                        {{-- <a href="{{ route('checkout', $part) }}" class="btn btn-primary w-100 mt-4 mb-4">Checkout</a>
                    --}}
                        <p><span class="fw-bold">Currus Connect ID: </span>{{ $part->article_nr }}</p>
                        <p><span class="fw-bold">{{ __('type-of-spare') }}: </span>{{ __('used-part') }}</p>
                        <p><span class="fw-bold">{{ __('car-part-engine-type') }}: </span>{{ $part->engine_type }}</p>
                        <p><span class="fw-bold">{{ __('car-info-gearbox') }}: </span>{{ $part->gearbox_nr }}</p>
                        <p><span class="fw-bold">{{ __('car-info-quality') }}: </span>{{ $part->quality }}</p>
                        @if ($part->quality == 'A+')
                            <p><strong>A+ </strong>{{ __('car-quality-A+') }}</p>
                        @elseif($part->quality == 'A')
                            <p><strong>A </strong>{{ __('car-quality-A') }}</p>
                        @elseif($part->quality == 'A*')
                            <p><strong>A* </strong>{{ __('car-quality-A*') }}</p>
                        @elseif($part->quality == 'M')
                            <p><strong>M </strong>{{ __('car-quality-M') }}</p>
                        @endif
                        <p><span class="fw-bold">{{ __('car-part-original') }}: </span>
                            <a href=" {{ route('car-parts.search-by-oem', $part->original_number) }}">{{ $part->original_number }}</a>
                        </p>
                        <p><span class="fw-bold">{{ __('chassi-nr') }}: </span> {{ $part->vin }} </p>
                        <p><span class="fw-bold">KBA:</span> {{ $part->kba_number }}</p>
                        <p><span class="fw-bold">{{ __('car-part-modelyear') }}: </span>{{ $part->model_year }}</p>
                        <p><span class="fw-bold">{{ __('car-part-mileage') }}:</span>
                            @if ($part->mileage_km == 999)
                                <strong>{{ __('unknown-message') }}</strong>
                            @else
                                {{ $part->mileage_km }} KM
                        @endif
                        <p><span class="fw-bold">{{ __('fuel-type') }}: </span>{{ $part->fuel }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="fw-bold">More Information</h4>
                        <p>Here you can add more details about the car part, such as its history, compatibility, and any
                            other relevant specifications.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    #fullview-container {
        background-color: white;
        border-radius: 0.2rem;
    }


    .large-text {
        font-size: 1.5rem;
    }

    .large-text-title {
        font-size: 1.3rem;
    }

    .thumb-container {
        flex: 1 0 21%;
        max-width: 10rem;
    }

    @media (max-width: 576px) {
        .thumb-container {
            flex: 1 0 46%;
            max-width: 100%;
        }
    }

    .thumb {
        border-radius: 0.5rem;
    }

    .thumb:hover {
        opacity: 0.7;
    }
</style>

<script>
    function changeImage(src) {
        document.getElementById('mainImage').src = src;
    }

    function showInfoPopup() {
        var popup = new bootstrap.Modal(document.getElementById('infoPopup'));
        popup.show();
    }
</script>
