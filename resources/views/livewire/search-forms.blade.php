<div>
    <div class="d-flex justify-content-center gap-3 mt-3">
        <!-- HSN + TSN Section -->
        <div class="col-3 mb-3 text-center">
              <a href="/car-parts/search/by-name?search=" class="fw-semibold btn btn-success">{{ __('browse')}}</a>

           {{-- <button wire:click="openForm('hsnTsn')" class="fw-semibold btn btn-success mb-3">{{__('kba-search')}}</button>--}}
            @if($openForm === 'hsnTsn')
                <div class="card" style="z-index:5; height: 26.5rem;">
                    <div class="card-body">
                        <p>{{__('kba-search-info')}}</p>
                        <livewire:kba-search :partTypes="$partTypes"/>
                    </div>
                </div>
            @endif
        </div>

        <!-- Car Model Section -->
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

        <!-- OEM Section -->
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
