<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $client_id  = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
		$this->client_id = config('app.client_id', '');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
		
		// Debugging: Log the user's role
		\Log::info('User role: ' . $user->role);
        if ($user && $user->role != 'member') {
			\Log::info('admin');
            return redirect('/admin');
        }

		\Log::info('member');
        return redirect($this->redirectTo);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->where('client_id', $this->client_id)->first();

		if (!$user) {
			if($request->has('from') && $request->input('from') == 'member'){
				return response()->json([
					'message' => 'Gagal Login.',
					'errors' => [
						'email' => [
							'Email atau password salah.'
						]
					]
				], 422);
			}

			return redirect()->back()->withErrors(['email' => 'Email atau password salah.'])
            	->withInput(['email' => $request->email]);
		}

        if ($user && $user->flag_approve === 'N') {
            return response()->json(['message' => 'Akun anda belum di approve, silahkan hubungi petugas perpustakaan.'], 403);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
			return $this->authenticated($request, Auth::user());
		}

        if ($user && $user->role === 'member') {
            return response()->json([
                'message' => 'Gagal Login.',
                'errors' => [
                    'email' => [
                        'Email atau password salah.'
                    ]
                ]
            ], 422);
        }

        return redirect()->back()->withErrors(['email' => 'Email atau password salah.'])
            ->withInput(['email' => $request->email]);
    }
}
