<div class="container mt-2">
    <div class="row justify-content-center gap-3">

        @if(App::getLocale() === 'ge')
        <div class="col-lg-3 col-md-4 col-12 mb-3 text-center position-relative">
        <button wire:click="openForm('hsnTsn')"
            class="fw-semibold btn btn-success mb-3 w-100 hsnTsnButton"
            onmouseover="showImage()"
            onmouseout="hideImage()">
        {{__('kba-search')}}
    </button>
    <img id="hsnTsnImage" src="{{ asset('hsn-tsn.jpg') }}" alt="HSN/TSN Information" class="d-none position-absolute" style="z-index: 1050; width: 92%;">

            @if($openForm === 'hsnTsn' && !$isSmallScreen)
            <div class="card mt-3" style="z-index:5; height: auto;">
                <div class="card-body pt-0">
                    <p>{{__('kba-search-info')}}</p>
                    <p>{{__('kba-search-info-hsn') }}</p>
                    <p>{{__('kba-search-info-tsn') }}</p>
                    <livewire:kba-search :partTypes="$partTypes"/>
                </div>
            </div>
            @endif
        </div>

        @else
        @if(App::getLocale() === 'dk')
                <div class="col-lg-3 col-md-4 col-12 mb-3 text-center">
                    <button wire:click="openForm('number-plate')" class="fw-semibold btn btn-success mb-3 w-100">{{__('number-plate-search')}}</button>

                    @if($openForm === 'number-plate' && !$isSmallScreen)
                        <div class="card mt-3" style="z-index:5; height: auto;">
                            <div class="card-body pt-0">
                                <p class="pt-2"><strong>{{__('oem-search-info')}}</strong></p>
                                <livewire:number-plate-search/>
                            </div>
                        </div>
                    @endif
                </div>
        @else
            <div class="col-lg-3 col-md-4 col-12 mb-3 text-center">
                <a href="/car-parts/search/by-name?search=" class="fw-semibold btn btn-primary mb-3 w-100">{{__('browse')}}</a>
            </div>
        @endif
        @endif

        <div class="col-lg-3 col-md-4 col-12 mb-3 text-center">
            <button wire:click="openForm('model')" class="fw-semibold btn btn-success mb-3 w-100">{{__('model-search')}}</button>
            @if($openForm === 'model' && !$isSmallScreen)
            <div class="card mt-3" style="z-index:5; height: auto;">
                <div class="card-body pt-0">
                    @include('partials.errors')
                    <p class="pt-2"><strong>{{__('model-search-info')}}</strong></p>
                    <livewire:model-search/>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-3 col-md-4 col-12 mb-3 text-center">
            <button wire:click="openForm('oem')" class="fw-semibold btn btn-success mb-3 w-100">{{__('oem-search')}}</button>
            @if($openForm === 'oem' && !$isSmallScreen)
            <div class="card mt-3" style="z-index:5; height: auto;">
                <div class="card-body pt-0">
                    <p class="pt-2"><strong>{{__('oem-search-info')}}</strong></p>
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

{{-- Modal for when no results for KBA --}}
<div id="noResultsModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100">{{ __('no-results') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ __('no-results-message') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">{{ __('close-message') }}</button>
                <a href="/contact" class="btn btn-primary">{{ __('contact-us') }}</a>
            </div>
        </div>
    </div>
</div>


<script>
    // Listen for the Livewire event to show the modal
    document.addEventListener('livewire:load', function () {
        Livewire.on('noResultsFound', () => {
            showModal();
        });
    });

    // Function to show the modal
    function showModal() {
        const modal = document.getElementById('noResultsModal');
        modal.style.display = 'block';
        modal.classList.add('show');
        modal.setAttribute('aria-modal', 'true');
        modal.setAttribute('role', 'dialog');
        document.body.classList.add('modal-open');
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        document.body.appendChild(backdrop);
    }

    // Function to close the modal
    function closeModal() {
        const modal = document.getElementById('noResultsModal');
        modal.style.display = 'none';
        modal.classList.remove('show');
        modal.removeAttribute('aria-modal');
        modal.removeAttribute('role');
        document.body.classList.remove('modal-open');
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    }

    function showImage() {
    if(window.innerWidth >= 992){
        document.getElementById('hsnTsnImage').classList.remove('d-none');
        document.getElementById('hsnTsnImage').classList.add('d-block');
    }

    }

    function hideImage() {
    if(window.innerWidth >= 992){
        document.getElementById('hsnTsnImage').classList.remove('d-block');
        document.getElementById('hsnTsnImage').classList.add('d-none');
    }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const isSmallScreen = window.innerWidth < 768;
        @this.set('isSmallScreen', isSmallScreen);
    });

    window.addEventListener('resize', function () {
        const isSmallScreen = window.innerWidth < 768;
        @this.set('isSmallScreen', isSmallScreen);
    });
</script>

