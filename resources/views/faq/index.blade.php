@extends('app')
@section('content')
    <div class="container pt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center bg-light p-3 rounded-3 shadow-sm">
                <li class="breadcrumb-item">
                    <a href="{{ route('landingpage') }}" class="text-decoration-none text-success">{{ __('home') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('faq') }}</li>
            </ol>
        </nav>

        <h3 class="text-center pt-4 fw-bold text-success display-6">{{ __('faq') }}</h3>
        <p class="text-center lead text-muted" style="font-size: 1.25rem;">
            {{ __('faq-intro') }} 
            <a class="link-success fw-bold" href="{{ route('contact') }}"> <br> {{ __('faq-email-msg') }}</a>
        </p>

        <div class="col-10 mx-auto pt-5">
            <!-- Tab navigation for categories -->
            <ul class="nav nav-tabs bg-light justify-content-center shadow-sm mt-2 rounded-3 p-2" id="faqTab" role="tablist">
                @foreach($questionCategories as $index => $questionCategory)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link @if($index == 0) active @endif text-success fw-bold" id="tab-{{ $index }}" data-bs-toggle="tab" href="#content-{{ $index }}" role="tab" aria-controls="content-{{ $index }}" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                            <i class="bi bi-question-circle-fill me-1"></i> {{ ucfirst($questionCategory) }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <!-- Tab content for each category -->
            <div class="tab-content mt-4 rounded-3 p-4" id="faqTabContent">
                @foreach($questionCategories as $index => $questionCategory)
                    @if(isset($faqs[$questionCategory]))
                        <div class="tab-pane fade @if($index == 0) show active @endif" id="content-{{ $index }}" role="tabpanel" aria-labelledby="tab-{{ $index }}">
                            <div class="list-group">
                                @foreach($faqs[$questionCategory] as $faq)
                                    <div class="list-group-item bg-white mb-4 p-4 rounded shadow-sm">
                                        <h5 class="faq-question text-success">{{ $faq['question'] }}</h5>
                                        <p class="text-muted">{{ $faq['answer'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Document Section -->
            <div class="pt-5">
                <h3 class="text-center pb-4 text-success fw-bold" style="font-size: 1.5rem;">{{ __('faq-files-intro') }}</h3>
                <div class="row">
                    @foreach ([
                        'cookies' => __('faq-cookies'), 
                        'fortrydelsesret' => __('faq-right-of-withdrawal'), 
                        'gdpr' => __('faq-gdpr'), 
                        'leveringsbetingelser' => __('faq-terms-of-sale')
                    ] as $doc => $title)
                        <div class="col-md-6 mb-4">
                            <div class="card shadow-sm h-100 rounded-3">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-success">{{ $title }}</h5>
                                    <a href="{{ asset($folder.'/'.$doc.'.'.$locale.'.pdf') }}" target="_blank" class="btn btn-outline-success me-2">View</a>
                                    <a href="{{ asset($folder.'/'.$doc.'.'.$locale.'.pdf') }}" download class="btn btn-success">Download</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <style>
        .faq-question {
            font-style: italic; 
            font-weight: bold; 
            font-size: 1.2rem;
            margin-bottom: 10px; 
            color: #28a745;
        }
    .nav-tabs .nav-link {
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        transition: background-color 0.3s, color 0.3s;
    }

    .nav-tabs .nav-link.active {
        background-color: #28a745; /* Green background for active tab */
        color: #fff !important;   /* White text for active tab */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Optional shadow for emphasis */
    }

    .nav-tabs .nav-link:not(.active):hover {
        background-color: #e8f5e9; /* Light green background on hover */
        color: #28a745;           /* Green text on hover */
    }
        .breadcrumb, .list-group-item, .card {
            border: none !important;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>

@endsection

@push('css')
<style>
    body {
        background-color: #dce0e6 !important;
        background-image: none !important;

    }
</style>
@endpush
