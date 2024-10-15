@extends('layouts.auth')

@section('content')
    <div class="row h-100">
        <div class="col-md-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="{{ url('/') }}"><img src="./images/logo/logo.png" alt="Logo" /></a>
                </div>
                
                @if($success)
                    <h1 class="auth-title">Terima Kasih Sudah Berkunjung!</h1>
                    <p class="auth-subtitle mb-4"></p>

                @else
                    <h1 class="auth-title">Pengunjung Offline</h1>
                    <p class="auth-subtitle mb-4"></p>

                    <form action="/offline-visitor" method="POST">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control" placeholder="Nama" id="name" name="name" value="{{ old('name') }}" autofocus />
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control" placeholder="Email" id="email" name="email" value="{{ old('email') }}" autofocus />
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>

                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                @endif
            </div>
        </div>
        <div class="col-md-7 d-none d-md-block">
            <div id="auth-right"></div>
        </div>
    </div>
@endsection
