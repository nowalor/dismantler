@extends('app')
@section('title', 'Currus Connect - Car Parts')
@section('content')
<div class="container mt-3">
    <h1 class="large-text font-bold">{{__('product-details')}}</h1>
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
                        <img id="mainImage" class="img-fluid rounded mb-2" src="{{ $firstImage->original_url }}" alt="Car part image" style="max-width: 100%; border-radius: 1rem;">
        
                        <!-- Thumbnail Images -->
                        <div class="row justify-content-center">
                            <div class="d-flex flex-wrap justify-content-center">
                                @foreach ($images as $image)
                                    <div class="p-1 thumb-container">
                                        <img class="img-thumbnail thumb" src="{{ $image->original_url }}" alt="Thumbnail {{ $loop->iteration }}" style="width: 100%; cursor: pointer;" onclick="changeImage('{{ $image->original_url }}')">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <img class="img-fluid rounded mb-4" src="https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/placeholder-car-parts.png" alt="Placeholder image" style="max-width: 100%; border-radius: 1rem;">
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Product Information -->
        <div class="col-md-6 pt-2">
            <div class="card shadow-sm mb-2">
                <div class="card-body">
                    <h3 class="fw-bold large-text">{{ $part->new_name }}</h3> 
                    <h4 class="text-primary large-text">{{ number_format($part->price_sek, 2) }} SEK <span class="text-muted">Incl. VAT</span> <a href="/contact"><i class="fas fa-info-circle ml-2"></i></a></h4>
                    <a href="{{ route('contact', ['part_name' => $part->new_name, 'article_nr' => $part->article_nr]) }}" class="btn btn-primary w-100 mt-4 mb-4">
                        {{ __('contact-us') }}
                    </a>
                    {{-- <a href="{{ route('checkout', $part) }}" class="btn btn-primary w-100 mt-4 mb-4">Checkout</a> --}}
                    <p><span class="fw-bold">Currus Connect ID: </span>{{ $part->article_nr }}</p>
                    <p><span class="fw-bold">{{__('type-of-spare')}}: </span>{{__('used-part')}}</p>
                    <p><span class="fw-bold">{{__('car-part-engine-type')}}: </span>{{ $part->engine_type }}</p>
                    <p><span class="fw-bold">{{__('car-info-gearbox')}}: </span>{{ $part->gearbox }}</p>
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
                    <p><span class="fw-bold">{{__('car-part-original')}}: </span>{{ $part->original_number}}</p>
                    <p><span class="fw-bold">{{__('chassi-nr')}}: </span> {{ $part->vin }} </p>
                    <p><span class="fw-bold">{{__('car-part-modelyear')}}: </span>{{ $part->model_year }}</p>
                    <p><span class="fw-bold">{{__('car-part-mileage')}}:</span>
                    @if($part->mileage_km == 999) 
                        <strong>{{__('unknown-message')}}</strong>
                    @else
                        {{ $part->mileage_km }} KM
                    @endif
                    <p><span class="fw-bold">{{__('fuel-type')}}: </span>{{ $part->fuel }}</p>
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
                    <p>Here you can add more details about the car part, such as its history, compatibility, and any other relevant specifications.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
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
</script>
