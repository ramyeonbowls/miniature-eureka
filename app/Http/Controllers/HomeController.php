<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show forbidden page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function forbidden()
    {
        if(auth()->user()->activated) {
            return redirect(\App\Providers\RouteServiceProvider::HOME);
        }

        return view('errors.403');
    }

    public function userInfo()
    {
        $user = auth()->user();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ], 200);
    }
}
