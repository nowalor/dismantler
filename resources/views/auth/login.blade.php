@extends('app')
@section('title', 'Login')
@section('content')
    <div class="container">
        @if($errors->any())
            @foreach($errors->all() as $error)
                {{ $error }}
            @endforeach
        @endif
        <div class="col-6 mx-auto pt-4">
            <div class="card">
                <div class="card-header">
                    Login
                </div>
                <div class="card-body">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email-login" class="form-label">Email address*</label>
                            <input name="email" type="email" class="form-control" id="email-login" placeholder="name@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="password-login" class="form-label">Password*</label>
                            <input name="password" type="password" class="form-control" id="password-login" placeholder="********">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary text-uppercase" type="button">login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
