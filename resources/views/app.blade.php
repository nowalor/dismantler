<!doctype html>
<html lang="en">

<head>
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-N8JFMF2L');</script>
    <!-- End Google Tag Manager -->
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="p:domain_verify" content="0abcbed29ec87ed8ceaa56be1b1b7e42" />
    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <link rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}" />
    @endforeach
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link href="https://fonts.cdnfonts.com/css/cooper-hewitt?styles=34279" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/favicon.ico">
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

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N8JFMF2L" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
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
                            <a class="nav-link {{ activeMenu('admin/newsletter') }}"
                               href="{{ route('admin.newsletter.index') }}">Newsletter</a>
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
                        <li class="nav-item">
                                <a class="text-danger nav-link {{ activeMenu('admin/blogs') }}"
                                    href="{{ route('admin.blogs.index') }}">Blog</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @endif

    <header class="navbar navbar-expand-sm navbar-dark bg-dark sticky-top">
        <nav class="container d-flex justify-content-between">
            <a href="{{ route('landingpage') }}" class="d-flex align-items-center text-decoration-none">
                <img class="d-inline-block" src="{{ asset('currus-logo.png') }}" width="50rem" height="50rem"
                    style="padding: 0.1rem;" alt="{{ __('alt-tags.homepage_logo_1') }}" />
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
                    <a href="{{ route('newsletter.index') }}" class="nav-link text-white">{{ __('newsletter') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('contact') }}" class="nav-link text-white">{{ __('contact') }}</a>
                </li>
            </ul>

                <!-- Language dropdown for larger screens (not crowded for better button visibility) -->
                <div class="dropdown ms-5 d-none d-md-block">
                    <button class="btn btn-secondary w-100 d-flex justify-content-center align-items-center"
                        type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('img/flags/' . LaravelLocalization::getCurrentLocale() . '.png') }}"
                            width="20" height="15" alt="Flag" class="me-2">
                        {{ config('languages.' . LaravelLocalization::getCurrentLocale() . '.name') }}
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="languageDropdown">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $language)
                            <li>
                                <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
                                    <img src="{{ asset('img/flags/' . $localeCode . '.png') }}" width="20" height="15"
                                        alt="{{ __('alt-tags.flag') . ' ' . __("countries.{$localeCode}")  }}" class="me-2">
                                    {{ Str::title($language['native']) }}
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
                        <img src="{{ asset('img/flags/' . LaravelLocalization::getCurrentLocale() . '.png')}}"
                            width="20" height="15" alt="{{ __('alt-tags.flag') . ' ' . __("countries.$localeCode")  }}"
                            class="me-2">
                        {{ config('languages.' . LaravelLocalization::getCurrentLocale() . '.name') }}
                    </button>
                    <ul class="dropdown-menu w-100" aria-labelledby="languageDropdownMobile">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $language)
                            <li>
                                <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
                                    <img src="{{ asset('img/flags/' . $localeCode . '.png') }}" width="20" height="15"
                                        alt="Flag">
                                    {{ Str::title($language['native']) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>
    </header>


<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-L7D5KSW306"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-L7D5KSW306');
</script>

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
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    @yield('js')
    <style>
        body {
            @if(!in_array(Route::currentRouteName(), ['checkout', 'checkout.success', 'approval']))
            background-image: url(' {{ asset('img/enginedark.jpg') }}');
            @endif background-size: cover;
        }

        /* .cta {
        background-image: url('
    {{ asset('img/engine.jpg') }}
        ');
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
            background-color: rgba(0, 0, 0, 0.7);
            position: absolute;
            top: 0;
            left: 0;
            z-index: 3;
        }

        .cta>* {
            position: relative;
            z-index: 4;
        }

        */
    </style>
    @stack('js')
</body>

</html>