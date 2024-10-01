<?php

namespace App\Http\Controllers;

use App\Logs;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
        $this->client_id = config('app.client_id', '');
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
        Carbon::setLocale('id');
        $user = auth()->user();

        $attr = DB::table('tattr_member as a')
            ->select([
                'a.birthday',
            ])
            ->where('a.client_id', $this->client_id)
            ->where('a.id', $user->id)
            ->get();
        
            $birthday   = $attr[0]->birthday ?? Carbon::now('Asia/Jakarta');
            $birthdayC  = Carbon::parse($birthday);
            $age        = $birthdayC->diffInYears(Carbon::now('Asia/Jakarta'));

        if($age >= $request->age){
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
    
    public function LastRead(Request $request)
    {
        Carbon::setLocale('id');
        $user = auth()->user();
        $logs = new Logs( Arr::last(explode("\\", get_class())) );
        $logs->write(__FUNCTION__, "START");
        DB::enableQueryLog();

        $existingRecord = DB::table('ttrx_read')
            ->where('book_id', $request->token)
            ->where('user_id', $user->id)
            ->where('start_read', $request->start)
            ->where('client_id', $this->client_id)
            ->first();

        if ($existingRecord) {
            $ttrx = DB::table('ttrx_read')
                ->where('book_id', $request->token)
                ->where('user_id', $user->id)
                ->where('start_read', $request->start)
                ->where('client_id', $this->client_id)
                ->update([
                    'end_read'      => Carbon::now('Asia/Jakarta'),
                    'flag_end'      => $request->active,
                    'updated_at'    => Carbon::now('Asia/Jakarta')
                ]);
        } else {
            $ttrx = DB::table('ttrx_read')
                ->insert([
                    'book_id'       => $request->token,
                    'start_read'    => $request->start,
                    'user_id'       => $user->id,
                    'client_id'     => $this->client_id,
                    'flag_end'      => $request->active,
                    'end_read'      => Carbon::now('Asia/Jakarta'),
                    'created_at'    => Carbon::now('Asia/Jakarta')
                ]);
        }

        $queries = DB::getQueryLog();
        for($q = 0; $q < count($queries); $q++) {
            $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
            $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
            $logs->write('SQL', $sql);
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        if($ttrx){
            return response()->json([
                'code' => '1',
                'message' => 'Ok!',
            ], 200);
        }else{
            return response()->json([
                'code' => '0',
                'message' => 'Failed!',
            ], 200);
        }
    }
}
