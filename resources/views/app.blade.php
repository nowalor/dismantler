<!doctype html>
<html lang="en">
<title>Currus Connect - Home</title>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> --}}
    <link href="https://fonts.cdnfonts.com/css/cooper-hewitt?styles=34279" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>@yield('title')</title>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link rel="icon" type="image/x-icon"
        href="https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/favicon.ico">
    @livewireStyles
    @stack('css')
    
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "AutoPartsStore",
          "name": "Currus Connect",
          "url": "https://currus-connect.com",
          "logo": "https://currus-connect.com/img/logos/white-logo-final-EN.png",
          "image": "https://currus-connect.com/img/logos/white-logo-final-EN.png",
          "description": "Currus Connect is your trusted source for motor vehicle parts and accessories, offering over 30 years of experience with used spare parts.",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "Rentemestervej 67",
            "addressLocality": "København",
            "postalCode": "2400",
            "addressCountry": "DK"
          },
          "contactPoint": [
        {
        "@type": "ContactPoint",
        "telephone": "",
        "email": "support@currus-connect.com",
        "contactType": "Customer Support",
        "availableLanguage": ["English", "Danish", "German", "French", "Swedish"]
            }
        ]
    }
</script>

</head>
<!-- As a heading -->
@if (auth()->user() && auth()->user()->is_admin)
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">

            <a class="navbar-brand" href="#">Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="" id="navbarNav">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="text-danger nav-link {{ activeMenu('admin/export-parts') }}"
                                href="{{ route('admin.export-parts.index') }}">EGLUIT parts</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.engine-types.index') }}" class="nav-link">Engine Types</a>
                        </li>
                        <li class="nav-item">
                            <a class="text-danger nav-link {{ activeMenu('admin/dito-numbers') }}"
                                href="{{ route('admin.dito-numbers.index') }}">Dito numbers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ activeMenu('admin/kba') }}"
                                href="{{ route('admin.kba.index') }}">KBA</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ activeMenu('admin/car-part-categories') }}"
                                href="{{ route('admin.part-types-categories.index') }}">Parts Categories</a>
                        </li>
                        <!-- °<li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.car-parts.index') }}">Parts</a>
                </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.new-parts') }}">Parts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.orders.index') }}">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.information') }}">Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="text-danger nav-link {{ activeMenu('admin/sbr-codes') }}"
                                href="{{ route('admin.sbr-codes.index') }}">SBR</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
@endif

<header class="navbar navbar-expand-sm navbar-dark bg-dark sticky-top">
    <nav class="container d-flex justify-content-between">
        <a href="{{ route('landingpage') }}" class="d-flex align-items-center text-decoration-none">
            <img class="d-inline-block" src="{{ asset('currus-logo.png') }}" width="50rem" height="50rem"
                style="padding: 0.1rem;" />
            <h4 class="text-white mb-0">Currus Connect</h4>
        </a>

        <!-- Toggle button for mobile view -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-3">
                <li class="nav-item">
                    <a href="/" class="nav-link text-white">{{ __('home') }}</a>
                </li>
                <li class="nav-item">
                    <a href="/car-parts/search/by-name?search=" class="nav-link text-white">{{ __('parts') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('about-us') }}" class="nav-link text-white">{{ __('about-us') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('faq') }}" class="nav-link text-white">{{ __('faq') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('contact') }}" class="nav-link text-white">{{ __('contact') }}</a>
                </li>
            </ul>

            <!-- Language dropdown for larger screens (not crowded for better button visibility) -->
            <div class="dropdown ms-5 d-none d-md-block">
                <button class="btn btn-secondary w-100 d-flex justify-content-center align-items-center"
                    type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('img/flags/' . config('languages.' . App::getLocale() . '.flag') . '.png') }}"
                        width="20" height="15" alt="Flag" class="me-2">
                    {{ config('languages.' . App::getLocale() . '.name') }}
                </button>
                <ul class="dropdown-menu w-100" aria-labelledby="languageDropdown">
                    @foreach (config('languages') as $localeCode => $language)
                        <li>
                            <a class="dropdown-item" href="{{ route('change.language', $localeCode) }}">
                                <img src="{{ asset('img/flags/' . $language['flag'] . '.png') }}" width="20"
                                    height="15" alt="Flag" class="me-2">
                                {{ $language['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Language dropdown for mobile devices (larger button and larger spacing) -->
            <div class="dropdown ms-auto mt-4 d-block d-md-none">
                <button
                    class="btn btn-secondary dropdown-toggle w-100 d-flex justify-content-center align-items-center"
                    type="button" id="languageDropdownMobile" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('img/flags/' . config('languages.' . App::getLocale() . '.flag') . '.png') }}"
                        width="20" height="15" alt="Flag" class="me-2">
                    {{ config('languages.' . App::getLocale() . '.name') }}
                </button>
                <ul class="dropdown-menu w-100" aria-labelledby="languageDropdownMobile">
                    @foreach (config('languages') as $localeCode => $language)
                        <li>
                            <a class="dropdown-item" href="{{ route('change.language', $localeCode) }}">
                                <img src="{{ asset('img/flags/' . $language['flag'] . '.png') }}" width="20"
                                    height="15" alt="Flag">
                                {{ $language['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
</header>

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <footer class="text-white text-center py-3">
        <p>&copy; {{ date('Y') }} Currus Connect. {{ __('copyright-text') }}</p>
    </footer>
@livewireScripts
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

@yield('js')
</body>
<style>
    body {
        @if(!in_array(Route::currentRouteName(), ['checkout', 'checkout.success', 'approval']))
            background-image: url(' {{ asset('img/enginedark.jpg') }}');
        @endif
        background-size: cover;
    }

    /* .cta {
        background-image: url(' {{ asset('img/engine.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        width: 100%;
        position: relative;
        overflow: hidden;
    }

    .cta::after {
        content: "";
        height: 100vh;
        width: 100%;
        background-color: rgba(0,0,0,0.7);
        position: absolute;
        top: 0;
        left: 0;
        z-index: 3;
    }

    .cta > * {
        position: relative;
        z-index: 4;
    } */
</style>
@stack('js')

</html>
