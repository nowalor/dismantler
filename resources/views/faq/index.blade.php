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
        <p class="text-center lead">
            {{ __('faq-intro') }}<a class="link-primary" href="{{ route('contact') }}"> <br> {{ __('faq-email-msg') }}</a>
        </p>

        <div class="col-10 mx-auto pt-5">
            <!-- Tab navigation for categories -->
            <ul class="nav nav-tabs" id="faqTab" role="tablist">
                @foreach($questionCategories as $index => $questionCategory)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link @if($index == 0) active @endif" id="tab-{{ $questionCategory }}" data-bs-toggle="tab" href="#content-{{ $questionCategory }}" role="tab" aria-controls="content-{{ $questionCategory }}" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                            {{ ucfirst($questionCategory) }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <!-- Tab content for each category -->
            <div class="tab-content pt-3" id="faqTabContent">
                @foreach($questionCategories as $index => $questionCategory)
                    @if(isset($questions[$questionCategory]))
                        <div class="tab-pane fade @if($index == 0) show active @endif" id="content-{{ $questionCategory }}" role="tabpanel" aria-labelledby="tab-{{ $questionCategory }}">
                            <div class="list-group">
                                @foreach($questions[$questionCategory] as $question)
                                    <div class="list-group-item">
                                        <h5 class="faq-question">{{ $question->question }}</h5>
                                        <p>{{ $question->answer }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
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
