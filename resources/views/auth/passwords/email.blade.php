@extends('layouts.auth')

@section('content')
    <div class="row h-100">
        <div class="col-md-5 col-12">
            <div id="auth-left">
                <div class="auth-logo"><a href="{{ url('/') }}"><img src="{{ asset('storage/images/logo/logo.png') }}" alt="Logo" /></a></div>
                <h1 class="auth-title">Lupa Kata Sandi</h1>
                <p class="auth-subtitle mb-4">Masukkan email Anda untuk menerima tautan pengaturan ulang kata sandi.</p>
                @if (session('status'))
                    <div class="alert alert-success" role="status">{{ session('status') }}</div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="email" class="form-control form-control-md @error('email') is-invalid @enderror" placeholder="Email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                        <div class="form-control-icon"><i class="bi bi-envelope"></i></div>
                        @error('email') <span class="invalid-feedback" role="alert">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-md shadow-md mt-3">Kirim Tautan</button>
                </form>
                <div class="text-center mt-5 text-md fs-10"><a href="{{ route('login') }}">Masuk admin</a> | <a href="{{ url('/mlogin') }}">Masuk member</a></div>
            </div>
        </div>
        <div class="col-md-7 d-none d-md-block"><div id="auth-right"></div></div>
    </div>
@endsection
