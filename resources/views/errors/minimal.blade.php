<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <link rel="icon" type="image/png" href="{{ asset('storage/images/logo/logo_small.png') }}">
        <style>
            * { box-sizing: border-box; }
            body {
                margin: 0;
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                background: #f7fafc;
                color: #a0aec0;
            }
            main {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .error {
                display: flex;
                align-items: center;
                font-size: 1.125rem;
                letter-spacing: .05em;
                text-transform: uppercase;
            }
            .code {
                padding: 0 1rem;
                border-right: 1px solid #cbd5e0;
            }
            .message { margin-left: 1rem; }
            @media (prefers-color-scheme: dark) {
                body { background: #1a202c; color: #cbd5e0; }
                .code { border-color: #4a5568; }
            }
        </style>
    </head>
    <body>
        <main>
            <div class="error">
                <div class="code">@yield('code')</div>
                <div class="message">@yield('message')</div>
            </div>
        </main>
    </body>
</html>
