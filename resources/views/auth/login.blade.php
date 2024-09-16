@extends('layouts.auth')

@section('content')
    <div class="row h-100">
        <div class="col-md-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="{{ url('/') }}"><img src="./images/logo/logo_03.png" alt="Logo" /></a>
                </div>
                <h1 class="auth-title">Masuk.</h1>
                <p class="auth-subtitle mb-4">Masuk dengan email yang di daftarkan</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" class="form-control form-control-md @error('email') is-invalid @enderror" placeholder="Email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" class="form-control form-control-md @error('password') is-invalid @enderror" placeholder="Kata Sandi" id="password" name="password" required autocomplete="current-password" />
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-check form-check-md d-flex align-items-end">
                        <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault" name="flexCheckDefault" {{ old('flexCheckDefault') ? 'checked' : '' }} />
                        <label class="form-check-label text-gray-600" for="flexCheckDefault">Tetap Masuk</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-md shadow-md mt-3">Masuk</button>
                </form>
                <div class="text-center mt-5 text-md fs-10">
                    <!-- <p class="text-gray-600">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="font-bold">Sign up</a>
                        .
                    </p> -->
                    <p>
                        <a class="font-bold" href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
                        .
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-7 d-none d-md-block">
            <div id="auth-right"></div>
        </div>
    </div>
@endsection
