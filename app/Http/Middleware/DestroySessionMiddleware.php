<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class DestroySessionMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }

            if ($user->flag_approve === 'N') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect($user->role === 'member' ? '/mlogin' : '/login')
                    ->withErrors(['email' => 'Akun anda belum di approve, silahkan hubungi petugas perpustakaan.']);
            }

            if (($user->role == 'admin' || $user->role == 'teacher') && $request->path() == '/') {
                Auth::logout();
                $request->session()->invalidate();
                return redirect('/');
            }

            if ($user->role == 'member' && $request->path() == 'admin') {
                Auth::logout();
                $request->session()->invalidate();
                return redirect('/admin');
            }
        }

        return $next($request);
    }
}
