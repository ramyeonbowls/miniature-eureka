@extends('layouts.auth')

@section('content')
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="{{ url('/') }}"><img src="./../storage/images/logo/logo.svg" alt="Logo" /></a>
                </div>
                <h1 class="auth-title">Forgot Password</h1>
                <p class="auth-subtitle mb-5">Input your email and we will send you reset password link.</p>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="email" class="form-control form-control-xl @error('email') is-invalid @enderror" placeholder="Email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Send</button>
                </form>
                <div class="text-center mt-5 text-lg fs-4">
                    <p class="text-gray-600">
                        Remember your account?
                        <a href="{{ route('login') }}" class="font-bold">Log in</a>
                        .
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right"></div>
        </div>
    </div>
@endsection
