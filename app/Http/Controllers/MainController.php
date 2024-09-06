<?php

namespace App\Http\Controllers;

use App\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //   $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('main');
    }

    /**
     * Show forbidden page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getInfo()
    {
        $user = auth()->user();

        if($user){
            return response()->json([
               'id' => $user->id,
               'name' => $user->name,
               'email' => $user->email,
               'role' => $user->role
            ], 200);
        }

        return response()->json([
            'id' => '',
            'name' => '',
            'email' => '',
            'role' => '',
        ], 200);
    }
}
