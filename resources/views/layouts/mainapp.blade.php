<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('images/logo/favicon.svg?' . rand(10000, 99999)) }}" type="image/x-icon" />
        <link rel="shortcut icon" href="{{ asset('images/logo/favicon.png?' . rand(10000, 99999)) }}" type="image/png" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        @yield('favicon')

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/sass/iconly.scss', 'resources/sass/themes/dark/app-dark.scss', 'resources/sass/pages/chat.scss', 'resources/sass/pages/datatables.scss', 'resources/sass/pages/dripicons.scss', 'resources/sass/pages/email.scss', 'resources/sass/pages/error.scss', 'resources/sass/pages/flag.scss', 'resources/sass/pages/form-element-select.scss', 'resources/sass/pages/simple-datatables.scss', 'resources/sass/pages/summernote.scss', 'resources/sass/pages/sweetalert2.scss', 'resources/js/main.js'])
    </head>
    <body>
        @vite(['resources/js/assets/static/js/initTheme.js'])

        <div id="usr-main-container">
            @yield('content')
        </div>

        @vite(['resources/js/assets/static/js/components/dark.js'])
    </body>
</html>
