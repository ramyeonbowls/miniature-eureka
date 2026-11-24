@extends('layouts.auth')

@section('content')
    <div class="row h-100">
        <div class="col-md-5 col-12">
            <div id="auth-left">
                <div class="auth-logo"><a href="{{ url('/') }}"><img src="{{ asset('storage/images/logo/logo.png') }}" alt="Logo" /></a></div>
                <h1 class="auth-title">Verifikasi Alamat Email Anda</h1>
                <p class="auth-subtitle mb-4">Sebelum melanjutkan, silakan cek email Anda dan klik tautan verifikasi.</p>
                @if (session('resent'))
                    <div class="alert alert-success" role="status">Tautan verifikasi baru telah dikirim ke email Anda.</div>
                @endif
                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-block btn-md shadow-md mt-3">Kirim Ulang Email Verifikasi</button>
                </form>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-link">Keluar</button>
                </form>
            </div>
        </div>
        <div class="col-md-7 d-none d-md-block"><div id="auth-right"></div></div>
    </div>
@endsection
