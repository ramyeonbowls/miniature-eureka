<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $loginPath = '/mlogin';

    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);
        $user->setRememberToken(Str::random(60));
        if (!$user->hasVerifiedEmail()) {
            $user->email_verified_at = now();
        }
        $user->save();
        if (Auth::id() === $user->getKey()) {
            Auth::logout();
        }
        event(new PasswordReset($user));
        $this->loginPath = $user->role === 'member' ? '/mlogin' : '/login';
    }

    protected function sendResetResponse(Request $request, $response)
    {
        return redirect()->route('password.success')->with('password_reset_login', $this->loginPath);
    }
}
