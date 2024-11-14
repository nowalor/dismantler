@extends("app")
@section("content")

<div class="container my-5">
            <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center bg-light p-3 rounded-3 shadow-sm">
                <li class="breadcrumb-item">
                    <a href="{{ route('landingpage') }}" class="text-decoration-none text-success">{{ __('home') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('about-us') }}</li>
            </ol>
        </nav>
    <!-- Header Section -->
    <div class="text-center">
        <h1 class="display-4 text-success fw-bold">{{ __('about-header') }}</h1>
        <p class="fs-6 lead text-muted">{{ __('about-intro') }}</p>
    </div>
    
    <!-- Content Section -->
    <div class="container my-4 text-center" style="max-width: 65%;">
        <p class="mt-4 font-italic fs-5 text-secondary">
            {{ __('about-text-one') }} <strong class="text-success">{{ __('currus-connect') }}</strong> {{ __('about-text-two') }}
        </p>
        
        <!-- Decorative Line -->
        <hr class="my-4 mx-auto" style="width: 50%; border-top: 2px solid #28a745;">
        
        <!-- About Details -->
        <h5 class="mt-3 font-italic text-muted">
            {{ __('about-text-three') }}
        </h5>
        <h5 class="mt-3 font-italic text-muted">
            {{ __('about-text-four') }}
        </h5>
        <h5 class="mt-3 font-italic text-muted">
            {{ __('about-text-five') }}
        </h5>
        <h5 class="mt-3 font-italic text-muted">
            {{ __('about-text-six') }}
        </h5>
        
        <!-- Guarantee Text -->
        <div class="mt-4 p-3 rounded bg-light shadow-sm">
            <h5 class="font-italic text-center text-success">
                {{ __('about-text-seven') }}
            </h5>
        </div>
    </div>
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
