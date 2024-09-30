<?php

namespace App\Http\Controllers;

use App\Logs;
use Carbon\Carbon;
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
    protected $client_id = '';
    public function __construct()
    {
        $this->middleware('auth');
        $this->client_id = env('APP_CLIENT_ID', '');
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
        $book = DB::table('tmapping_book as a')
            ->select([
                'b.filename'
            ])
            ->join('tbook as b', 'a.isbn', '=', 'b.isbn')
            ->where('a.client_id', $this->client_id)
            ->where('a.book_id', $request->token)
            ->get();
        $file = $book[0]->filename;

        $filePath = 'private/pdf/'.$file;
        $filename = explode('.', basename($filePath))[0];

        $encryptedContents = Storage::get($filePath);
        $decryptedContents = Crypt::decrypt($encryptedContents);
        return response()->make($decryptedContents, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'. $filename .'.pdf"'
        ]);
    }

    public function ReadCheck(Request $request)
    {
        $user = auth()->user();

        $attr = DB::table('tattr_member as a')
            ->select([
                'a.birthday',
            ])
            ->where('a.client_id', $this->client_id)
            ->where('a.id', $user->id)
            ->get();
        
            $birthday   = $attr[0]->birthday ?? Carbon::now();
            $birthdayC  = Carbon::parse($birthday);
            $age        = $birthdayC->diffInYears(Carbon::now());

        if($age >= 50){
            return response()->json([
               'code' => '1',
               'message' => 'Ok',
            ], 200);
        }

        return response()->json([
            'code' => '0',
            'message' => 'Anda Belum Cukup Usia Untuk membaca Buku Ini!',
        ], 200);
    }
}
