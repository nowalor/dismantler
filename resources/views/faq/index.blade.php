@extends('app')
@section('content')
    <div class="container pt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ route('landingpage') }}">{{ __('home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('faq') }}</li>
            </ol>
        </nav>
        <h3 class="text-center pt-2">
            {{ __('faq') }}
        </h3>
        <p class="text-center lead" style="font-size: 1.5rem;">
            {{ __('faq-intro') }}<a class="link-primary" href="{{ route('contact') }}"> <br> {{ __('faq-email-msg') }}</a>
        </p>

        <div class="col-10 mx-auto pt-5">
            <!-- Tab navigation for categories -->
            <ul class="nav nav-tabs" id="faqTab" role="tablist">
                @foreach($questionCategories as $index => $questionCategory)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link @if($index == 0) active @endif" id="tab-{{ $index }}" data-bs-toggle="tab" href="#content-{{ $index }}" role="tab" aria-controls="content-{{ $index }}" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                            {{ ucfirst($questionCategory) }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <!-- Tab content for each category -->
            <div class="tab-content pt-3" id="faqTabContent">
                @foreach($questionCategories as $index => $questionCategory)
                    @if(isset($faqs[$questionCategory]))
                        <div class="tab-pane fade @if($index == 0) show active @endif" id="content-{{ $index }}" role="tabpanel" aria-labelledby="tab-{{ $index }}">
                            <div class="list-group">
                                @foreach($faqs[$questionCategory] as $faq)
                                    <div class="list-group-item">
                                        <h5 class="faq-question">{{ $faq['question'] }}</h5>
                                        <p>{{ $faq['answer'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Document Section -->
            <div class="pt-5">
                <h3 class="text-center pb-4" style="font-size: 1.7rem;">{{ __('faq-files-intro') }}</h3>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('faq-cookies') }}</h5>
                                <a href="{{ asset($folder.'/cookies.'.$locale.'.pdf') }}" target="_blank" class="btn btn-primary">View</a>
                                <a href="{{ asset($folder.'/cookies.'.$locale.'.pdf') }}" download class="btn btn-secondary">Download</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('faq-right-of-withdrawal') }}</h5>
                                <a href="{{ asset($folder.'/fortrydelsesret.'.$locale.'.pdf') }}" target="_blank" class="btn btn-primary">View</a>
                                <a href="{{ asset($folder.'/fortrydelsesret.'.$locale.'.pdf') }}" download class="btn btn-secondary">Download</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('faq-gdpr') }}</h5>
                                <a href="{{ asset($folder.'/gdpr.'.$locale.'.pdf') }}" target="_blank" class="btn btn-primary">View</a>
                                <a href="{{ asset($folder.'/gdpr.'.$locale.'.pdf') }}" download class="btn btn-secondary">Download</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('faq-terms-of-sale') }}</h5>
                                <a href="{{ asset($folder.'/leveringsbetingelser.'.$locale.'.pdf') }}" target="_blank" class="btn btn-primary">View</a>
                                <a href="{{ asset($folder.'/leveringsbetingelser.'.$locale.'.pdf') }}" download class="btn btn-secondary">Download</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .faq-question {
            font-style: italic; 
            font-weight: bold; 
            font-size: 1.1rem;
            margin-bottom: 10px; 
        }
    </style>

@endsection

@push('css')
<style>
    body {
        background-color: white !important; 
        background-image: none !important;
    }
</style>
@endpush
