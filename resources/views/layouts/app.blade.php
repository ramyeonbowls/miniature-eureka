<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('storage/images/logo/favicon.png?' . rand(10000, 99999)) }}" type="image/png" />
        @yield('favicon')

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/sass/iconly.scss', 'resources/sass/themes/dark/app-dark.scss', 'resources/sass/pages/chat.scss', 'resources/sass/pages/datatables.scss', 'resources/sass/pages/dripicons.scss', 'resources/sass/pages/email.scss', 'resources/sass/pages/error.scss', 'resources/sass/pages/flag.scss', 'resources/sass/pages/form-element-select.scss', 'resources/sass/pages/simple-datatables.scss', 'resources/sass/pages/summernote.scss', 'resources/sass/pages/sweetalert2.scss', 'resources/js/app.js'])
    </head>
    <body>
        @vite(['resources/js/assets/js/initTheme.js'])

        <div id="main-container">
            @yield('content')
        </div>

        @vite(['resources/js/assets/js/components/dark.js', 'resources/js/assets/js/components/sidebar.js'])
    </body>
</html>
