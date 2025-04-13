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
            <ul class="navbar-nav ms-auto gap-3" style="font-size: medium;">
                <li class="nav-item">
                    <a href="/" class="nav-link text-white">{{ __('home') }}</a>
                </li>
                <li class="nav-item">
                    <a href="/car-parts/search/by-name?search="
                        class="nav-link text-white">{{ __('parts') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('about-us') }}" class="nav-link text-white">{{ __('about-us') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('faq') }}" class="nav-link text-white">{{ __('faq') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('newsletter.index') }}"
                        class="nav-link text-white">{{ __('newsletter') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('contact') }}" class="nav-link text-white">{{ __('contact') }}</a>
                </li>
            </ul>

            <!-- Language dropdown for larger screens (not crowded for better button visibility) -->
            <div class="dropdown ms-5 d-none d-md-block" style="padding-bottom: 0.3rem;">
                <label for="language" style="display: flex; justify-content: center; color: white; font-size: small; padding-bottom: 0.2rem;">{{ __('language') }}</label>
                <button class="btn btn-secondary w-100 d-flex justify-content-center align-items-center"
                    type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                    style="padding: 0.25rem 0.5rem;">
                    <img src="{{ asset('img/flags/' . LaravelLocalization::getCurrentLocale() . '.png') }}"
                        width="20" height="15" alt="Flag" class="me-2">
                    {{ config('languages.' . LaravelLocalization::getCurrentLocale() . '.name') }}
                </button>
                <ul class="dropdown-menu w-100" aria-labelledby="languageDropdown">
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $language)
                        <li>
                            <a class="dropdown-item"
                                href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
                                <img src="{{ asset('img/flags/' . $localeCode . '.png') }}" width="20"
                                    height="15"
                                    alt="{{ __('alt-tags.flag') . ' ' . __("countries.{$localeCode}") }}"
                                    class="me-2">
                                {{ Str::title($language['native']) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Browsing country dropdown --}}
            <div class="dropdown ms-3 d-none d-md-block" style="padding-bottom: 0.3rem;">
                <label for="browsingCountry" style="display: flex; justify-content: center; color: white; font-size: small; padding-bottom: 0.2rem;">{{ __('shipping') }}</label>
                <button class="btn btn-secondary w-100 d-flex justify-content-center align-items-center"
                    type="button" id="countryDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                    style="padding: 0.25rem 0.5rem;">
                    @php
                        $selectedCountry = session('browsing_country') ?? 'de';
                    @endphp
                    <img src="{{ asset('img/flags/' . strtolower($selectedCountry) . '.png') }}" width="20"
                        height="15" alt="Flag" class="me-2">
                    {{ __("countries.{$selectedCountry}") }}
                </button>
                <ul class="dropdown-menu w-100" aria-labelledby="countryDropdown">
                    @foreach (['da', 'de', 'fr', 'pl', 'sv'] as $countryCode)
                        <li>
                            <form method="POST" action="{{ route('setBrowsingCountry') }}">
                                @csrf
                                <input type="hidden" name="country" value="{{ $countryCode }}">
                                <button type="submit" class="dropdown-item d-flex align-items-center w-100"
                                    style="padding: 0.25rem 0.5rem;">
                                    <img src="{{ asset('img/flags/' . strtolower($countryCode) . '.png') }}"
                                        width="20" height="15" class="me-2">
                                    {{ __("countries.{$countryCode}") }}
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>


            <!-- Language dropdown for mobile devices (larger button and larger spacing) -->
            <div class="dropdown ms-auto mt-4 d-block d-md-none">
                <label for="language" style="display: flex; justify-content: center; color: white; font-size: small; padding-bottom: 0.2rem;">{{ __('language') }}</label>
                <button
                    class="btn btn-secondary dropdown-toggle w-100 d-flex justify-content-center align-items-center"
                    type="button" id="languageDropdownMobile" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('img/flags/' . LaravelLocalization::getCurrentLocale() . '.png') }}"
                        width="20" height="15"
                        alt="{{ __('alt-tags.flag') . ' ' . __("countries.$localeCode") }}" class="me-2">
                    {{ config('languages.' . LaravelLocalization::getCurrentLocale() . '.name') }}
                </button>
                <ul class="dropdown-menu w-100" aria-labelledby="languageDropdownMobile">
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $language)
                        <li>
                            <a class="dropdown-item"
                                href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
                                <img src="{{ asset('img/flags/' . $localeCode . '.png') }}" width="20"
                                    height="15" alt="Flag">
                                {{ Str::title($language['native']) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Browsing country dropdown for mobile devices -->
            <div class="dropdown ms-auto mt-4 d-block d-md-none">
                <label for="browsingCountry" style="display: flex; justify-content: center; color: white; font-size: small; padding-bottom: 0.2rem;">{{ __('shipping') }}</label>
                <button
                    class="btn btn-secondary dropdown-toggle w-100 d-flex justify-content-center align-items-center"
                    type="button" id="countryDropdownMobile" data-bs-toggle="dropdown" aria-expanded="false">
                    @php
                        $selectedCountry = session('browsing_country') ?? 'de';
                    @endphp
                    <img src="{{ asset('img/flags/' . strtolower($selectedCountry) . '.png') }}" width="20"
                        height="15" alt="Flag" class="me-2">
                    {{ __("countries.{$selectedCountry}") }}
                </button>
                <ul class="dropdown-menu w-100" aria-labelledby="countryDropdownMobile">
                    @foreach (['da', 'de', 'fr', 'pl', 'sv'] as $countryCode)
                        <li>
                            <form method="POST" action="{{ route('setBrowsingCountry') }}">
                                @csrf
                                <input type="hidden" name="country" value="{{ $countryCode }}">
                                <button type="submit" class="dropdown-item d-flex align-items-center w-100">
                                    <img src="{{ asset('img/flags/' . strtolower($countryCode) . '.png') }}"
                                        width="20" height="15" class="me-2">
                                    {{ __("countries.{$countryCode}") }}
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
</header>
