<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>@yield('title')</title>
</head>
<body>
<!-- As a heading -->
@if(auth()->user() && auth()->user()->is_admin)
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dito-numbers.index') }}">Dito numbers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.kba.index') }}">KBA</a>
                </li>
                <!-- °<li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.car-parts.index') }}">Parts</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.new-parts') }}">Parts</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@endif

<header class="sticky-top bg-dark">
    <nav class="container d-flex justify-content-between py-2">
        <a href="{{ route('home') }}" class="d-flex gap-2 align-items-center text-decoration-none">
            <i style="font-size: 1.6rem;" class="fa fa-solid fa-car"></i>
            <h3 class="text-white">Autoteile</h3>
        </a>
        <ul class="nav">
            <li class="nav-item d-flex">
                <a href="/car-parts" class="nav-link text-white">Parts</a>
                <a href="{{ route('about-us') }}" class="nav-link text-white">About us</a>
                <a href="{{ route('faq') }}" class="nav-link text-white">Faq</a>
                <a href="{{ route('contact') }}" class="nav-link text-white">Contact</a>
            </li>
        </ul>
    </nav>
</header>


@yield('content')
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
</body>
<style>

    .cta {
        background-image: url(' {{asset('img/homepage-banner.jpg') }}');
        background-size: cover;

        height: 120vh;
        width: 100%;
        position: relative;
    }
    .cta::after {
        content: "";
        height: 100%;
        width: 100%;
        background-color: rgba(0,0,0,0.7);
        position: absolute;
        top: 0;
        left: 0;
        z-index: 4;
    }
</style>
@stack('js')

</html>
