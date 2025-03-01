@extends('app')

@section('title', 'Sign up for newsletter')

@section('content')
    <div class="container d-flex justify-content-center pt-4">
        <div class="col-6">
        <div class="card">
            <div class="card-header">Sign up </div>
            <div class="card-body">
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        Thank you for signing up. You have been added to the currus-connect newsletter.
                    </div>
                @endif
                <form action="{{ route('newsletter.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email*</label>
                        <input required type="email" name="email" class="form-control"
                               placeholder="Email" >
                        <div class="form-text">We'll never share your email with anyone else.</div>
                    </div>

                    <div class="mb-3">
                        <div class="mb-3 form-check">
                            <input  required type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1"> I agree to recieve emails from currus-connect.com</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary w-100">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
@endsection
