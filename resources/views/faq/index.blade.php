@extends('app')
@section('content')
    <div class="container pt-5">
        <h3 class="text-center">
            FAQ
        </h3>
        <p class="text-center lead">
            This is the FAQ page. Here you can find a list of frequently asked questions. Not finding what your looking
            for?<a class="link-primary" href="{{ route('contact') }}"> Send us an email.</a>
        </p>

        <div class="col-10 mx-auto pt-5">
            <div class="accordion">
                @foreach($faqs as $question)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="question-{{$question->id}}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
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
                @endforeach
            </div>
        </div>
    </div>
@endsection
