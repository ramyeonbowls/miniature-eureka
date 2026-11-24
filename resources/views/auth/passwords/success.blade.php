@extends('layouts.auth')

@section('content')
    <div class="row h-100">
        <div class="col-md-5 col-12">
            <div id="auth-left">
                <div class="auth-logo"><a href="{{ url('/') }}"><img src="{{ asset('storage/images/logo/logo.png') }}" alt="Logo" /></a></div>
                <h1 class="auth-title">Berhasil</h1>
                <p class="auth-subtitle mb-4">Kata sandi Anda berhasil diperbarui. Silakan masuk kembali menggunakan kata sandi baru.</p>
                <a href="{{ url($loginPath) }}" class="btn btn-primary btn-block btn-md shadow-md mt-3">Masuk</a>
            </div>
        </div>
        <div class="col-md-7 d-none d-md-block"><div id="auth-right"></div></div>
    </div>
@endsection
