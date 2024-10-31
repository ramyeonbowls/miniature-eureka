<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('storage/images/logo/favicon.svg?' . rand(10000, 99999)) }}" type="image/x-icon" />
        <link rel="shortcut icon" href="{{ asset('storage/images/logo/favicon.png?' . rand(10000, 99999)) }}" type="image/png" />
        @yield('favicon')

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/sass/pages/error.scss'])
    </head>
    <body>
        @vite(['resources/js/assets/js/initTheme.js'])

        <div id="main-container">
            <div class="error-page container">
                <div class="col-md-8 col-12 offset-md-2">
                    <div class="text-center">
                        <img class="img-error" src="{{ asset('images/samples/error-403.svg?' . rand(10000, 99999)) }}" alt="Forbidden" />
                        <h1 class="error-title">Forbidden</h1>
                        <p class="fs-5 text-gray-600">You are unauthorized to see this page.</p>
                        <a href="/" class="btn btn-lg btn-outline-primary mt-3">Go Home</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
