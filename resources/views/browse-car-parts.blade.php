@extends('app')

@section('content')
<div class="d-flex flex-column" style="height: 93.9vh; background-image: url('/img/engine.jpg'); background-position: center; background-size: cover;">
    <div class="d-flex h-100">
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
        <div class="flex-fill bg-dark d-flex align-items-center justify-content-center" style="opacity: 0.85;">
            <div class="text-center">
                <h1 class="text-white font-weight-bold mb-2" style="font-size: 3rem;">
                    ECO-FRIENDLY
                </h1>
                <h1 class="text-white font-weight-bold mb-2" style="font-size: 3rem;">
                    JOURNEYS START WITH
                </h1>
                <h1 class="text-white font-weight-bold mb-2" style="font-size: 3rem;">
                    CURRUS CONNECT
                </h1>
            </div>
        </div>
    </div>
</div>
@endsection
