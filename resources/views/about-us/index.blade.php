@extends("app")
@section('title', 'Currus-connect.com: ' . __('page-titles.about_us'))
@section("content")

<div class="container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center bg-light p-3 rounded-3 shadow-sm">
                <li class="breadcrumb-item">
                    <a href="{{ route('landingpage') }}" class="text-decoration-none text-success">{{ __('home') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('about-us') }}</li>
            </ol>
        </nav>
    <div class="text-center">
        <h1 class="display-4 text-success fw-bold">{{ __('about-header') }}</h1>
        <p class="fs-6 lead text-muted">{{ __('about-intro') }}</p>
    </div>

    <div class="container my-4 text-center bg-white p-3 rounded">
        <p class="mt-4 font-italic fs-5 text-secondary">
            {{ __('about-text-one') }} <strong class="text-success">{{ __('currus-connect') }}</strong> {{ __('about-text-two') }}
        </p>

        <hr class="my-4 mx-auto" style="width: 50%; border-top: 2px solid #28a745;">

        <h5 class="pt-2 font-italic text-muted">
            {{ __('about-text-three') }}
            {{ __('about-text-four') }}
        </h5>

        <h5 class="pt-2 font-italic text-muted">
            {{ __('about-text-five') }}
            {{ __('about-text-six') }}
            {{ __('about-text-seven') }}
        </h5>

        <h5 class="pt-2">
            {{ __('about-text-eight') }}
            <br>
            {{ __('about-text-nine') }}
        </h5>

        <div class="mt-4 p-3 rounded bg-light shadow-sm">
            <h5 class="font-italic text-center text-success">
                {{ __('about-text-seven') }}
            </h5>
        </div>
    </div>

    @php $locale = app()->getLocale(); @endphp

    @if ($locale === 'da')
        {{-- Danish --}}
        <div class="container my-5 bg-white p-3 rounded shadow-sm">
            <div class="row align-items-stretch">
                <div class="col-md-6 d-flex align-items-center justify-content-center mb-4 mb-md-0">
                    <img src="/tires.png" alt="Pictures of tires stacked on top of each other" class="img-fluid w-100 h-100 object-fit-cover rounded">
                </div>

                <div class="col-md-6 text-start">
                    <h4 class="text-success">Impressum</h4>
                    <p class="mb-1">Currus Connect ApS</p>
                    <p class="mb-1">Rentemestervej 67</p>
                    <p class="mb-1">DK 2400 København NV</p>
                    <p class="mb-3">Danmark</p>

                    <div class="col-md-7 text-start">
                        <h4 class="text-success">CVR</h4>
                        <p>44583712</p>
                    </div>

                    <h4 class="text-success">Ledelse</h4>
                    <p class="mb-1">Markus Priess</p>
                    <p class="mb-1">Customer Service: +49 (0) 5144 7459981 & +0045 7734 3877</p>
                    <p class="mb-1">Mail: <a href="mailto:service@currus-connect.com">service@currus-connect.com</a></p>
                    <p class="mb-0">Telefontid: Mandag - Fredag: 9.00 - 16.00</p>
                </div>
            </div>
        </div>

    @elseif ($locale === 'de')
        {{-- German --}}
        <div class="container my-5 bg-white p-3 rounded shadow-sm">
                <div class="row align-items-stretch">
                    <div class="col-md-6 d-flex align-items-center justify-content-center mb-md-0">
                        <img src="/tires.png" alt="Pictures of tires stacked on top of each other" class="img-fluid w-auto h-auto object-fit-cover rounded">
                    </div>

                    <div class="col-md-6 text-start">
                        <h4 class="text-success">Impressum</h4>
                        <p class="mb-1">Currus Connect ApS</p>
                        <p class="mb-1">Rentemestervej 67</p>
                        <p class="mb-1">DK 2400 København NV</p>
                        <p class="mb-2">Danmark</p>

                        <div class="col-md-7 text-start">
                            <h4 class="text-success">UID</h4>
                            <p>DK44583712</p>
                        </div>

                        <h4 class="text-success">Geschäftsführung</h4>
                        <p class="mb-1">Vertreten durch: Herr Markus Priess</p>
                        <h4 class="text-success">Kundendienst</h4>
                        <p class="mb-1">Rufen Sie uns gerne auf +49 (0) 5144 7459981 oder ++45 7734 3877</p>
                        <p class="mb-1">oder schicken Sie uns ein E-Mail an <a href="mailto:service@currus-connect.com">service@currus-connect.com</a></p>
                        <p>Sie können uns telefonisch errreichen: Montag - Freitag: 9.00 – 16.00</p>
                    </div>
                </div>
        </div>

    @else
        {{-- everything thats not DA OR DE --}}
        <div class="container my-5 bg-white p-3 rounded shadow-sm">
            <div class="row align-items-stretch">
                <div class="col-md-6 d-flex align-items-center justify-content-center mb-4 mb-md-0">
                    <img src="/tires.png" alt="Pictures of tires stacked on top of each other" class="img-fluid w-100 h-100 object-fit-cover rounded">
                </div>

                <div class="col-md-6 text-start">
                    <h4 class="text-success">Impressum</h4>
                    <p class="mb-1">Currus Connect ApS</p>
                    <p class="mb-1">Rentemestervej 67</p>
                    <p class="mb-1">DK 2400 København NV</p>
                    <p class="mb-3">Danmark</p>

                    <div class="mb-3">
                        <h4 class="text-success">Sales tax identification number (VAT):</h4>
                        <p>DK44583712</p>
                    </div>

                    <h4 class="text-success">Management</h4>
                    <p class="mb-1">Markus Priess</p>
                    <p class="mb-1">Customer Service: +45 77 34 38 77</p>
                    <p class="mb-1">Mail: <a href="mailto:service@currus-connect.com">service@currus-connect.com</a></p>
                    <p class="mb-0">Office time: Monday - Friday: 9.00 - 16.00</p>
                </div>
            </div>
        </div>
    @endif

</div>

@endsection

@push('css')
<style>
    body {
        background-color: #dce0e6 !important;
        background-image: none !important;
    }
    .display-4 {
        font-weight: bold;
        letter-spacing: 1px;
    }
</style>
@endpush
