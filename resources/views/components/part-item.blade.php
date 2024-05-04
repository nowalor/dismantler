{{-- <div class="col-6 p-4">
    <div class="card">
        <div class="card-header">
            {{ $part->name }}
        </div>
        <div class="card-body">
            <p><span class="fw-bold">#: </span> {{ $part->id}}</p>
            <p><span class="fw-bold">Type: </span> {{ $part->carPartType->name }}</p>
            <p><span class="fw-bold">Article number: </span> {{ $part->article_nr }}</p>
            <p><span class="fw-bold">Original number: </span> {{ $part->original_number }}</p>
            <p><span class="fw-bold">Price(SEK): </span> {{ $part->price_sek }}</p>
            <p><span class="fw-bold">Total(EUR): </span> €{{ $part->new_price + $part->shipment }}</p>
            <p><span class="fw-bold">[NEW]Price(EUR): </span> €{{ $part->new_price }}</p>
            <p><span class="fw-bold">[B2B]Price(EUR): </span> €{{ $part->business_price }}</p>
            <p><span class="fw-bold">Shipment(EUR): </span> €{{ $part->shipment }}</p>
            <p><span class="fw-bold">Engine code: </span> {{ $part->engine_code }}</p>
            <p><span class="fw-bold">Engine type: </span> {{ $part->engine_type }}</p>
            <p><span class="fw-bold">Fuel: </span> {{ $part->fuel }}</p>
            <p><span class="fw-bold">Gearbox: </span> {{ $part->subgroup ?? $part->gearbox }}</p>
            <p><span class="fw-bold">Mileage(KM): </span> {{ $part->mileage_km }}</p>
            <p><span class="fw-bold">Vin: </span> {{ $part->vin }}</p>
            <p><span class="fw-bold">Model year: </span> {{ $part->model_year }}</p>
            <p><span class="fw-bold">SBR PART CODE: </span> {{ $part->sbr_part_code }}</p>
            <p><span class="fw-bold">SBR CAR CODE: </span> {{ $part->sbr_car_code }}</p>
            <p><span class="fw-bold">Kbas: </span> @foreach($part->my_kba as $kba) <a href="">{{ $kba->hsn }}
                    {{ $kba->tsn }}</a>,@endforeach</p>
            <a href="{{ route('checkout', $part) }}" class="btn btn-primary w-100">View
                part</a>
            <img class="card-img-bottom mt-2"
                 src="{{ (count($part->carPartImages) && !$part->carPartImages[0]->is_placeholder) ? asset("storage/img/car-part/{$part->id}/{$part->carPartImages[0]->image_name_blank_logo}") : 'http://46.101.206.99/storage/img/car-part/placeholder.jpg' }}"
                 alt="">
        </div>
    </div>
</div> --}}

<div class="card">
    <div class="card-header d-flex fw-bold">
        <p class="me-3">Information about part</p>
        <p class="me-3">Article number</p>
        <span class="me-3">Odometer (KM)</span>
        <span class="me-3">Model Year</span>
        <span class="me-3">Quality</span>
        <span>Price</span>        
    </div>
    <div class="card-body">
        <div class="card-first-section">
            <p><span class="fw-bold">Type: </span> {{ $part->carPartType->name }}</p>
        <p><span class="fw-bold">Article number: </span> {{ $part->article_nr }}</p>
        <p><span class="fw-bold">Original number: </span> {{ $part->original_number }}</p>
        </div>
        <div>

        </div>
        div
        <p><span class="fw-bold">Type: </span> {{ $part->carPartType->name }}</p>
        <p><span class="fw-bold">Article number: </span> {{ $part->article_nr }}</p>
        <p><span class="fw-bold">Original number: </span> {{ $part->original_number }}</p>
        <p><span class="fw-bold">Price(SEK): </span> {{ $part->price_sek }}</p>
        <p><span class="fw-bold">Total(EUR): </span> €{{ $part->new_price + $part->shipment }}</p>
        <p><span class="fw-bold">[NEW]Price(EUR): </span> €{{ $part->new_price }}</p>
        <p><span class="fw-bold">[B2B]Price(EUR): </span> €{{ $part->business_price }}</p>
        <p><span class="fw-bold">Shipment(EUR): </span> €{{ $part->shipment }}</p>
        <p><span class="fw-bold">Engine code: </span> {{ $part->engine_code }}</p>
        <p><span class="fw-bold">Engine type: </span> {{ $part->engine_type }}</p>
        <p><span class="fw-bold">Fuel: </span> {{ $part->fuel }}</p>
        <p><span class="fw-bold">Gearbox: </span> {{ $part->subgroup ?? $part->gearbox }}</p>
        <p><span class="fw-bold">Mileage(KM): </span> {{ $part->mileage_km }}</p>
        <p><span class="fw-bold">Vin: </span> {{ $part->vin }}</p>
        <p><span class="fw-bold">Model year: </span> {{ $part->model_year }}</p>
        <p><span class="fw-bold">SBR PART CODE: </span> {{ $part->sbr_part_code }}</p>
        <p><span class="fw-bold">SBR CAR CODE: </span> {{ $part->sbr_car_code }}</p>
        <p><span class="fw-bold">Kbas: </span> @foreach($part->my_kba as $kba) <a href="">{{ $kba->hsn }}
                {{ $kba->tsn }}</a>,@endforeach</p>
        <a href="{{ route('checkout', $part) }}" class="btn btn-primary w-100">View
            part</a>
        <img class="card-img-bottom mt-2"
             src="{{ (count($part->carPartImages) && !$part->carPartImages[0]->is_placeholder) ? asset("storage/img/car-part/{$part->id}/{$part->carPartImages[0]->image_name_blank_logo}") : 'http://46.101.206.99/storage/img/car-part/placeholder.jpg' }}"
             alt="">
    </div>
  </div>