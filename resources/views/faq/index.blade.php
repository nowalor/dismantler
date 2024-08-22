@extends('app')
@section('content')
    <div class="container pt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href=" {{ route('landingpage') }} ">{{__('home')}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{__('faq')}}</li>
            </ol>
        </nav>
        <h3 class="text-center pt-2">
            {{__('faq')}}
        </h3>
        <p class="text-center lead">
            {{__('faq-intro')}}<a class="link-primary" href="{{ route('contact') }}"> <br> {{__('faq-email-msg')}}</a>
        </p>

        <div class="col-10 mx-auto pt-5">
            <div class="accordion">
                @foreach($questionCategories as $questionCategory)
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="questionCategory-{{ $questionCategory }}">
                            <button class="accordion-button text-success bg-success bg-opacity-50 collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#questionCategory-collapse-{{ $questionCategory }}" aria-controls="questionCategory-collapse-{{ $questionCategory }}">
                                {{ ucfirst($questionCategory) }}
                            </button>
                        </h2>
                        <div id="questionCategory-collapse-{{ $questionCategory }}" class="accordion-collapse collapse"
                             data-bs-parent="#questionCategory-{{ $questionCategory }}">
                            <div class="accordion-body">
                                <div class="accordion">
                                    {{-- @foreach($questions[$questionCategory] as $question)
                                        <div class="accordion-item mb-3">
                                            <h2 class="accordion-header" id="question-{{$question->id}}">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#question-collapse-{{ $question->id }}">
                                                    {{ $question->question }}
                                                </button>
                                            </h2>
                                            <div id="question-collapse-{{ $question->id }}" class="accordion-collapse collapse"
                                                 data-bs-parent="#question-{{$question->id}}">
                                                <div class="accordion-body">
                                                    {{ $question->answer }}
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
