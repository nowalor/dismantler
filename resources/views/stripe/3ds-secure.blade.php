@extends('app')

@section('content')
    {{ $clientSecret }}
    <div>
        TODO, make this page nice!!
    </div>
@endsection

@push('js')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = new Stripe('{{ config('services.stripe.key') }}')
    console.log('here')

    stripe.handleCardAction("{{ $clientSecret }}")
        .then(function(result) {
            if(result.error) {
                console.log('here')
                window.location.replace("{{ route('cancelled') }}")
            } else {
                console.log('here')
                window.location.replace("{{ route('approval') }}")
            }
        })
</script>
@endpush
