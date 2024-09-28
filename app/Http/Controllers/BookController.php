<?php

namespace App\Http\Controllers;

use App\Logs;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getBook(Request $request)
    {
        $filePath = 'private/pdf/encrypt.gns';

        $filename = explode('.', basename($filePath))[0];

        $encryptedContents = Storage::get($filePath);
        $decryptedContents = Crypt::decrypt($encryptedContents);
        return response()->make($decryptedContents, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'.pdf"'
        ]);
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
