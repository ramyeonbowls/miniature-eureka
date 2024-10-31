<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta property="og:site_name" content="{{ env('APP_NAME') }}">
        <meta property="og:title" content="{{ env('APP_NAME') }}" />
        <meta property="og:description" content="Aplikasi Perpustakaan Digital Berbasis Website" />
        <meta property="og:image" itemprop="image" content="{{ env('APP_URL') }}/storage/images/logo/favicon.png" />
        <meta property="og:image:width" content="200">
        <meta property="og:image:height" content="200">
        <meta property="og:type" content="website" />
        <meta property="og:updated_time" content="1440432930" />
        <meta property="og:url" content="{{ env('APP_URL') }}" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('storage/images/logo/favicon.png?' . rand(10000, 99999)) }}" type="image/png" />

        <script type="text/javascript">
            if (window.top !== window.self) {
                window.top.location = window.self.location;
            }
        </script>
        @yield('favicon')

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/sass/iconly.scss', 'resources/sass/themes/dark/app-dark.scss', 'resources/sass/pages/chat.scss', 'resources/sass/pages/datatables.scss', 'resources/sass/pages/dripicons.scss', 'resources/sass/pages/email.scss', 'resources/sass/pages/error.scss', 'resources/sass/pages/flag.scss', 'resources/sass/pages/form-element-select.scss', 'resources/sass/pages/simple-datatables.scss', 'resources/sass/pages/summernote.scss', 'resources/sass/pages/sweetalert2.scss', 'resources/js/main.js'])
    </head>
    <body>
        @vite(['resources/js/assets/js/initTheme.js'])

        <div id="usr-main-container">
            @yield('content')
        </div>

        @vite(['resources/js/assets/js/components/dark.js', 'resources/js/assets/js/pages/horizontal-layout.js'])
    </body>
</html>
