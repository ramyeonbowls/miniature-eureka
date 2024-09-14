<?php

namespace App\Http\Controllers;

use App\Logs;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
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
    public function index(Request $request)
    {
        return view('readbook');
    }

    public function getInfo()
    {
        $user = auth()->user();

        if($user && $user->role == 'member'){
            return response()->json([
               'name' => $user->name,
            ], 200);
        }

        return response()->json([
            'name' => '',
        ], 200);
    }
}
