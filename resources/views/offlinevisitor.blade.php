@extends('layouts.auth')

@section('content')
    <div class="row h-100">
        <div class="col-md-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="{{ url('/') }}"><img src="./images/logo/logo.png" alt="Logo" /></a>
                </div>
                
                @if($success)
                    <h1 class="auth-title">Terima Kasih Sudah Mengisi Form Kunjungan Perpustakaan.<br>Selamat Membaca</h1>
                    <p class="auth-subtitle mb-4"></p>

                @else
                    <h1 class="auth-title">Pengunjung Offline</h1>
                    <p class="auth-subtitle mb-4"></p>

                    <form action="/offline-visitor" method="POST">
                        @csrf
                        <label for="name">Nama Lengkap</label>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control" placeholder="Nama Lengkap" id="name" name="name" value="{{ old('name') }}" autofocus/>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <label for="email">Email</label>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control" placeholder="Email" id="email" name="email" value="{{ old('email') }}"/>
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>

                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <label for="nik">Nomor Identitas</label>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control" placeholder="Nomor Identitas" id="nik" name="nik" required />
                            <div class="form-control-icon">
                                <i class="bi bi-card-text"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <label for="jenis-kelamin-floating">Jenis Kelamin</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">--</option>
                                <option value="L">Laki - Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </form>
                @endif
            </div>
        </div>
        <div class="col-md-7 d-none d-md-block">
            <div id="auth-right"></div>
        </div>
    </div>
@endsection
