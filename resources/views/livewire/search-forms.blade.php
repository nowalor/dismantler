<div class="container mt-2">
    <div class="row justify-content-center gap-3">
        <!-- Conditional Rendering of Buttons -->

        <!-- HSN/TSN Search Button -->
        <div class="col-lg-3 col-md-4 col-12 mb-3 text-center position-relative">
            <button wire:click="openForm('hsnTsn')" class="fw-semibold btn btn-success mb-3 w-100">{{__('kba-search')}}</button>
            @if($openForm === 'hsnTsn' && !$isSmallScreen)
            <div class="card mt-3" style="z-index:5; height: auto;">
                <div class="card-body">
                    <p>{{__('kba-search-info')}}</p>
                    <p>{{__('kba-search-info-hsn')}}</p>
                    <p>{{__('kba-search-info-tsn')}}</p>
                    <livewire:kba-search :partTypes="$partTypes"/>
                </div>
            </div>
            @endif
        </div>

        <!-- Model Search Button -->
        <div class="col-lg-3 col-md-4 col-12 mb-3 text-center">
            <button wire:click="openForm('model')" class="fw-semibold btn btn-success mb-3 w-100">{{__('model-search')}}</button>
            @if($openForm === 'model' && !$isSmallScreen)
            <div class="card mt-3" style="z-index:5; height: auto;">
                <div class="card-body">
                    @include('partials.errors')
                    <p>{{__('model-search-info')}}</p>
                    <livewire:model-search/>
                </div>
            </div>
            @endif
        </div>

        <!-- OEM Search Button -->
        <div class="col-lg-3 col-md-4 col-12 mb-3 text-center">
            <button wire:click="openForm('oem')" class="fw-semibold btn btn-success mb-3 w-100">{{__('oem-search')}}</button>
            @if($openForm === 'oem' && !$isSmallScreen)
            <div class="card mt-3" style="z-index:5; height: auto;">
                <div class="card-body">
                    <p>{{__('oem-search-info')}}</p>
                    <livewire:oem-search/>
                </div>
            </div>
            @endif
        </div>

        <!-- For Small Screens: Always Show the Clicked Button Last -->
        @if($isSmallScreen)
            @if($openForm === 'hsnTsn')
            <div class="col-12 mb-3 text-center position-relative">
                <button wire:click="openForm('hsnTsn')" class="fw-semibold btn btn-success mb-3 w-100">{{__('kba-search')}}</button>
                <div class="card mt-3" style="z-index:5; height: auto;">
                    <div class="card-body">
                        <p>{{__('kba-search-info')}}</p>
                        <p>{{__('kba-search-info-hsn')}}</p>
                        <p>{{__('kba-search-info-tsn')}}</p>
                        <livewire:kba-search :partTypes="$partTypes"/>
                    </div>
                </div>
            </div>
            @elseif($openForm === 'model')
            <div class="col-12 mb-3 text-center">
                <button wire:click="openForm('model')" class="fw-semibold btn btn-success mb-3 w-100">{{__('model-search')}}</button>
                <div class="card mt-3" style="z-index:5; height: auto;">
                    <div class="card-body">
                        @include('partials.errors')
                        <p>{{__('model-search-info')}}</p>
                        <livewire:model-search/>
                    </div>
                </div>
            </div>
            @elseif($openForm === 'oem')
            <div class="col-12 mb-3 text-center">
                <button wire:click="openForm('oem')" class="fw-semibold btn btn-success mb-3 w-100">{{__('oem-search')}}</button>
                <div class="card mt-3" style="z-index:5; height: auto;">
                    <div class="card-body">
                        <p>{{__('oem-search-info')}}</p>
                        <livewire:oem-search/>
                    </div>
                </div>
            </div>
            @endif
        @endif
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

    // hover only on large screens
    @media (min-width: 992px) {
        button:hover + #hsnTsnImage {
            display: block;
        }
    }

    @media (max-width: 768px) {
    .row .mb-3 {
        margin-bottom: 0.1rem !important; 
    }
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const isSmallScreen = window.innerWidth < 768;
        @this.set('isSmallScreen', isSmallScreen);
    });

    window.addEventListener('resize', function () {
        const isSmallScreen = window.innerWidth < 768;
        @this.set('isSmallScreen', isSmallScreen);
    });
</script>
