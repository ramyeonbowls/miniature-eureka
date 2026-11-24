<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $appName = static function (): string {
            $name = DB::table('tclient')
                ->where('client_id', config('app.client_id'))
                ->value('application_name');

            return trim((string) $name) ?: config('app.name');
        };

        VerifyEmail::toMailUsing(function ($user, $url) use ($appName) {
            $name = $appName();

            return (new MailMessage)
                ->subject('Verifikasi Email Akun '.$name)
                ->view('emails.action', [
                    'appName' => $name,
                    'greeting' => 'Halo, '.$user->name.'!',
                    'lines' => [
                        'Terima kasih telah mendaftar di '.$name.'.',
                        'Silakan verifikasi alamat email Anda. Akun baru dapat digunakan setelah email terverifikasi.',
                    ],
                    'actionText' => 'Verifikasi Email',
                    'actionUrl' => $url,
                    'footer' => 'Jika Anda tidak merasa mendaftar, abaikan email ini.',
                ]);
        });

        ResetPassword::toMailUsing(function ($user, $token) use ($appName) {
            $name = $appName();
            $url = route('password.reset', ['token' => $token, 'email' => $user->getEmailForPasswordReset()]);
            $expire = config('auth.passwords.'.config('auth.defaults.passwords').'.expire');

            return (new MailMessage)
                ->subject('Atur Ulang Kata Sandi '.$name)
                ->view('emails.action', [
                    'appName' => $name,
                    'greeting' => 'Halo, '.$user->name.'!',
                    'lines' => [
                        'Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda.',
                        'Tautan ini berlaku selama '.$expire.' menit.',
                    ],
                    'actionText' => 'Atur Ulang Kata Sandi',
                    'actionUrl' => $url,
                    'footer' => 'Jika Anda tidak meminta pengaturan ulang kata sandi, abaikan email ini. Kata sandi Anda tidak akan berubah.',
                ]);
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
