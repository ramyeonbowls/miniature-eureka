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
