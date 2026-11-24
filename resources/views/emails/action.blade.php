<!DOCTYPE html>
<html lang="id">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>{{ $appName }}</title></head>
<body style="margin:0;padding:0;background:#f3f5f9;font-family:Arial,Helvetica,sans-serif;color:#333">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="padding:32px 12px">
        <tr><td align="center">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;background:#fff;border-radius:8px">
                <tr><td align="center" style="background:#435ebe;padding:24px">
                    <img src="{{ asset('storage/images/logo/logo.png') }}" alt="{{ $appName }}" style="max-width:180px;max-height:70px"><br>
                    <strong style="font-size:22px;color:#fff">{{ $appName }}</strong>
                </td></tr>
                <tr><td style="padding:32px">
                    <h2 style="font-size:20px;color:#25396f">{{ $greeting }}</h2>
                    @foreach ($lines as $line)
                        <p style="font-size:15px;line-height:1.6">{{ $line }}</p>
                    @endforeach
                    <p style="text-align:center;margin:28px 0"><a href="{{ $actionUrl }}" style="background:#435ebe;color:#fff;text-decoration:none;font-weight:bold;padding:12px 28px;border-radius:6px">{{ $actionText }}</a></p>
                    <p style="font-size:13px;color:#6b7280">{{ $footer }}</p>
                    <p style="font-size:12px;word-break:break-all">Jika tombol tidak berfungsi, salin dan buka tautan berikut:<br><a href="{{ $actionUrl }}">{{ $actionUrl }}</a></p>
                </td></tr>
                <tr><td align="center" style="background:#f9fafb;padding:16px;font-size:12px;color:#6b7280">Email ini dikirim otomatis, mohon tidak membalas. &copy; {{ date('Y') }} {{ $appName }}</td></tr>
            </table>
        </td></tr>
    </table>
</body>
</html>
