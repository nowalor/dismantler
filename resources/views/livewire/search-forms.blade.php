<div>
    <div class="d-flex justify-content-center gap-3 mt-3">
        <!-- HSN + TSN Section -->
        <div class="col-3 mb-3 text-center">
            <button wire:click="openForm('hsnTsn')" class="fw-semibold btn btn-success mb-3">SEARCH BY HSN + TSN</button>
            @if($openForm === 'hsnTsn')
                <div class="card" style="z-index:5; height: 27rem;">
                    <div class="card-body">
                        <p>
                            Search for a specific car if you know the HSN and TSN. This is the most accurate and fastest way to
                            find car parts for your car.
                        </p>
                        <livewire:kba-search :partTypes="$partTypes"/>
                    </div>
                </div>
            @endif
        </div>

        <!-- Car Model Section -->
        <div class="col-3 mb-3 text-center" style="text-align: left;">
            <button wire:click="openForm('model')" class="fw-semibold btn btn-success mb-3">SEARCH BY CAR MODEL</button>
            @if($openForm === 'model')
                <div class="card" style="z-index:5; height: 27rem;">
                    <div class="card-body">
                        @include('partials.errors')
                        <p>
                            If you don't know the HSN and TSN or you want a more open search you can search by car model.
                        </p>
                        <livewire:model-search/>
                    </div>
                </div>
            @endif
        </div>

        <!-- OEM Section -->
        <div class="col-3 mb-3 text-center">
            <button wire:click="openForm('oem')" class="fw-semibold btn btn-success mb-3">SEARCH BY OEM</button>
            @if($openForm === 'oem')
                <div class="card" style="z-index:5; height: 27rem;">
                    <div class="card-body">
                        <p>
                            Very detailed search that you can use if you have the original spare part number (OEM), gearbox code, or engine code.
                        </p>
                        <livewire:oem-search/>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
