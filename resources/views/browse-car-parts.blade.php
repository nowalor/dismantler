@extends('app')

@section('content')
<div class="d-flex flex-column" style="min-height: 100vh; background-image: url('/img/engine.jpg'); background-position: center; background-size: cover; background-repeat: no-repeat;">
    <div class="d-flex flex-grow-1">
        {{-- LEFT SIDE MENU BAR // PARTS NAVIGATION BAR 1/4 --}}
        <div class="d-flex flex-column w-25 bg-dark text-white" style="opacity: 0.85;">
            <div class="px-5 flex-grow-1">
                <!-- Navigation links -->
                <h1 class="display-5 font-weight-bold mt-3 ml-2 pt-4">PARTS</h1>
                <nav class="mt-4">
                    <ul class="list-unstyled">
                        <hr>
                        <li class="py-3 px-4"><a href="#" class="text-white text-decoration-none d-block" style="font-size: 1.5rem;">All</a></li>
                        <hr>
                        <li class="py-3 px-4"><a href="#" class="text-white text-decoration-none d-block" style="font-size: 1.5rem;">Motors</a></li>
                        <hr>
                        <li class="py-3 px-4"><a href="#" class="text-white text-decoration-none d-block" style="font-size: 1.5rem;">Gearboxes</a></li>
                        <hr>
                        <li class="py-3 px-4"><a href="#" class="text-white text-decoration-none d-block" style="font-size: 1.5rem;">Underbody</a></li>
                        <hr>
                        <li class="py-3 px-4"><a href="#" class="text-white text-decoration-none d-block" style="font-size: 1.5rem;">Car Interior</a></li>
                        <hr>
                        <li class="py-3 px-4"><a href="#" class="text-white text-decoration-none d-block" style="font-size: 1.5rem;">Car Exterior</a></li>
                        <hr>
                        <li class="py-3 px-4"><a href="#" class="text-white text-decoration-none d-block" style="font-size: 1.5rem;">Contact Us</a></li>
                        <hr>
                    </ul>
                </nav>
                <div class="d-flex justify-content-start pt-6">
                    <ul class="list-unstyled d-flex">
                        <li class="mx-3"><a class="fab fa-facebook text-white" rel="noopener noreferrer" target="_blank" href="https://www.facebook.com/" style="font-size: 2.3rem;"></a></li>
                        <li class="mx-3"><a class="fab fa-linkedin text-white" rel="noopener noreferrer" target="_blank" href="https://www.linkedin.com/" style="font-size: 2.3rem;"></a></li>
                        <li class="mx-3"><a class="fab fa-instagram text-white" rel="noopener noreferrer" target="_blank" href="https://www.instagram.com/" style="font-size: 2.3rem;"></a></li>
                        <li class="mx-3"><a class="fab fa-twitter text-white" rel="noopener noreferrer" target="_blank" href="https://twitter.com/?lang=da" style="font-size: 2.3rem;"></a></li>
                    </ul>    
                </div>
            </div>
        </div>

        {{-- MIDDLE AND RIGHT SIDE 3/4 --}}
        <div class="container bg-dark text-white flex-grow-1" style="opacity: 0.95;">
            <div class="row pt-2">
            </div>
            <x-part-list :parts="$parts" :sortRoute="route('car-parts.search-by-name')"/>
            {{ $parts->links() }}
        </div>
        
    </div>
</div>
@endsection
