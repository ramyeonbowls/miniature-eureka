@extends('layouts.auth')

@section('content')
    <div class="row h-100">
        <div class="col-md-5 col-12">
            <div id="auth-left">
                <div class="auth-logo"><a href="{{ url('/') }}"><img src="{{ asset('storage/images/logo/logo.png') }}" alt="Logo" /></a></div>
                <h1 class="auth-title">Atur Ulang Kata Sandi</h1>
                <p class="auth-subtitle mb-4">Masukkan email dan kata sandi baru Anda.</p>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}" />
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="email" type="email" class="form-control form-control-md @error('email') is-invalid @enderror" name="email" value="{{ old('email', $email) }}" placeholder="Email" required autocomplete="email" autofocus />
                        <div class="form-control-icon"><i class="bi bi-envelope"></i></div>
                        @error('email') <span class="invalid-feedback" role="alert">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="password" type="password" class="form-control form-control-md @error('password') is-invalid @enderror" name="password" placeholder="Kata sandi baru" required autocomplete="new-password" />
                        <div class="form-control-icon"><i class="bi bi-shield-lock"></i></div>
                        @error('password') <span class="invalid-feedback" role="alert">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="password-confirm" type="password" class="form-control form-control-md" name="password_confirmation" placeholder="Ulangi kata sandi baru" required autocomplete="new-password" />
                        <div class="form-control-icon"><i class="bi bi-shield-lock"></i></div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-md shadow-md mt-3">Atur Ulang Kata Sandi</button>
                </form>
            </div>
        </div>
        <div class="col-md-7 d-none d-md-block"><div id="auth-right"></div></div>
    </div>
@endsection
