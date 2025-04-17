<!doctype html>
<html lang="en">

<x-head />

<body>
    <x-google-tag-manager />
    <x-google-gtag-key />

    @auth
        @if (auth()->user() && auth()->user()->is_admin)
            <x-admin-nav-bar />
        @endif
    @endauth

    <x-main-header />

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <x-main-footer />

    @livewireScripts

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    @yield('js')
    <style>
        body {
            @if (!in_array(Route::currentRouteName(), ['checkout', 'checkout.success', 'approval', 'admin.fenix.stats', 'admin.fenix.part-types']))
                background-image: url(' {{ asset('img/enginedark.jpg') }}');
            @endif
            background-size: cover;
        }

    </style>
    @stack('js')
</body>
</html>
