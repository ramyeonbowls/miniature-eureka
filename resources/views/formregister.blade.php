<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
    <head>
    <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <link rel="shortcut icon" href="{{ asset('storage/images/logo/favicon.png?' . rand(10000, 99999)) }}" type="image/x-icon" />
        <link rel="shortcut icon" href="{{ asset('storage/images/logo/favicon.png?' . rand(10000, 99999)) }}" type="image/png" />

        <script type="text/javascript">
            if (window.top !== window.self) {
                window.top.location = window.self.location;
            }
        </script>

        <title>{{ config('app.name', 'Laravel') }}</title>

        @vite(['resources/sass/app.scss', 'resources/sass/themes/dark/app-dark.scss', 'resources/sass/pages/auth.scss', 'resources/js/form.js'])
    </head>
    <body>
        @vite(['resources/js/assets/js/initTheme.js'])
        <div id="form-register-container"></div>
        @vite(['resources/js/assets/js/components/dark.js'])
    </body>
</html>
