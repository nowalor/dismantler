<div>
    <div class="d-flex justify-content-center gap-3 mt-3">
        <div class="col-3 mb-3 text-center position-relative">
            <button wire:click="openForm('hsnTsn')" class="fw-semibold btn btn-success mb-3">{{__('kba-search')}}</button>
            <img id="hsnTsnImage" src="{{ asset('hsn-tsn.jpg') }}" alt="HSN TSN Image">
            @if($openForm === 'hsnTsn')
                <div class="card" style="z-index:5; height: 26.5rem;">
                    <div class="card-body">
                        <p>{{__('kba-search-info')}}</p>
                        <p>{{__('kba-search-info-hsn')}}</p>
                        <p>{{__('kba-search-info-tsn')}}</p>
                        <livewire:kba-search :partTypes="$partTypes"/>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-3 mb-3 text-center" style="text-align: left;">
            <button wire:click="openForm('model')" class="fw-semibold btn btn-success mb-3">{{__('model-search')}}</button>
            @if($openForm === 'model')
                <div class="card" style="z-index:5; height: 26.5rem;">
                    <div class="card-body">
                        @include('partials.errors')
                        <p>{{__('model-search-info')}}</p>
                        <livewire:model-search/>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-3 mb-3 text-center">
            <button wire:click="openForm('oem')" class="fw-semibold btn btn-success mb-3">{{__('oem-search')}}</button>
            @if($openForm === 'oem')
                <div class="card" style="z-index:5; height: 26.5rem;">
                    <div class="card-body">
                        <p>{{__('oem-search-info')}}</p>
                        <livewire:oem-search/>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    #hsnTsnImage {
        display: none;
        position: absolute;
        top: 3rem; 
        left: 50%;
        transform: translateX(-60%);
        z-index: 100;
        max-width: 30rem; 
        height: auto;
    }

    button:hover + #hsnTsnImage {
        display: block;
    }
</style>
