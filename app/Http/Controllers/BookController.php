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
use Yajra\DataTables\Facades\DataTables;

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
            ->join('tbook as b', 'a.book_id', '=', 'b.book_id')
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
        // $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        // $logs->write(__FUNCTION__, "START");
        // DB::enableQueryLog();

        $check_age  = $this->AgeCheck($request);
        $age        = json_decode($check_age->getContent(), true);

        if($age['code'] == '2'){
            return response()->json($age, 200);
        }

        $cek_stock = DB::table('tmapping_book as a')
            ->select([
                DB::raw("a.copy - IFNULL(d.total, 0) as remaining")
            ])
            ->leftJoin(DB::raw("(
                    SELECT
                        src.book_id,
                        SUM(CASE WHEN src.total > 1 THEN 1 ELSE src.total END) AS total
                    FROM (
                        SELECT sr.book_id, COUNT(sr.book_id) AS total, sr.user_id
                        FROM (
                            SELECT book_id, user_id
                            FROM ttrx_read
                            WHERE
                                client_id = '".$this->client_id."'
                                AND flag_end != 'Y'
                            
                            UNION ALL
                            
                            SELECT book_id, user_id
                            FROM trent_book
                            WHERE
                                client_id = '".$this->client_id."'
                                AND flag_end != 'Y'
                                AND user_id != '".$user->id."'
                        ) sr
                        group by sr.book_id, sr.user_id
                    ) src
                    GROUP BY src.book_id) as d"), function($join) {
                $join->on('a.book_id', '=', 'd.book_id');
            })
            ->where('a.client_id', '=', $this->client_id)
            ->where('a.book_id', '=', $request->pdfToken)
            ->first();

        // $queries = DB::getQueryLog();
        // for($q = 0; $q < count($queries); $q++) {
        //     $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
        //     $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
        //     $logs->write('SQL', $sql);
        // }
        // $logs->write(__FUNCTION__, "STOP\r\n");    

        if($cek_stock->remaining > 0){
            return response()->json([
                'code' => '1',
                'message' => 'Ok',
            ], 200);
        }else{
            return response()->json([
                'code' => '2',
                'message' => 'Stok buku sudah habis, silahkan tunggu!',
            ], 200);
        }

        return response()->json([
            'code' => '0',
            'message' => 'Terjadi kesalahan silahkan dicoba kembali!',
        ], 200);
    }
    
    public function AgeCheck(Request $request)
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
            'code' => '2',
            'message' => 'Anda Belum Cukup Usia Untuk membaca Buku Ini!',
        ], 200);
    }
    
    public function LastRead(Request $request)
    {
        Carbon::setLocale('id');
        $user = auth()->user();
        // $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        // $logs->write(__FUNCTION__, "START");
        // DB::enableQueryLog();

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

        // $queries = DB::getQueryLog();
        // for($q = 0; $q < count($queries); $q++) {
        //     $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
        //     $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
        //     $logs->write('SQL', $sql);
        // }
        // $logs->write(__FUNCTION__, "STOP\r\n");

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

    public function RentBook(Request $request)
    {
        Carbon::setLocale('id');
        $user = auth()->user();
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, "START");
        DB::enableQueryLog();

        $rent_day = 3;
        try {
            $rent_days  = DB::select("SELECT `value` FROM tparameter WHERE `name`='rent_book';");
            $rent_day   = $rent_days ? (int) $rent_days[0]->value : 3;
        } catch (\PDOException $e) {
            $logs->write("ERROR PARAMETER='rent_book'", $e->getMessage() ."\n");
        }

        $check_age  = $this->AgeCheck($request);
        $age        = json_decode($check_age->getContent(), true);

        if($age['code'] == '2'){
            return response()->json($age, 200);
        }
        
        $check_book = $this->RentCheck();
        $book       = json_decode($check_book->getContent(), true);

        if($book['code'] == '2'){
            return response()->json($book, 200);
        }

        $date       = Carbon::now('Asia/Jakarta');
        $end_date   = $date->copy()->addDays(3);
        $rent       = DB::table('trent_book')
                    ->insert([
                        'client_id'     => $this->client_id,
                        'user_id'       => $user->id,
                        'book_id'       => $request->pdfToken,
                        'start_date'    => $date,
                        'end_date'      => $end_date,
                        'flag_end'      => 'N',
                        'created_at'    => Carbon::now('Asia/Jakarta')
                    ]);

        $queries = DB::getQueryLog();
        for($q = 0; $q < count($queries); $q++) {
            $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
            $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
            $logs->write('SQL', $sql);
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        if($rent){
            return response()->json([
               'code' => '1',
               'message' => 'Berhasil Pinjam Buku!',
            ], 200);
        }

        return response()->json([
            'code' => '0',
            'message' => 'Gagal Bisa Pinjam Buku!',
        ], 200);
    }

    public function RentCheck()
    {
        Carbon::setLocale('id');
        $user = auth()->user();
        // $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        // $logs->write(__FUNCTION__, "START");
        // DB::enableQueryLog();

        $rent_book = 3;
        try {
            $rent_books  = DB::select("SELECT `value` FROM tparameter WHERE `name`='maks_rent_book';");
            $rent_book   = $rent_books ? (int) $rent_books[0]->value : 3;
        } catch (\PDOException $e) {
            $logs->write("ERROR PARAMETER='maks_rent_book'", $e->getMessage() ."\n");
        }

        $now        = Carbon::now('Asia/Jakarta');
        $date       = $now->format('Y-m-d');
        $end_date   = $now->addDays($rent_book);
        $query_book = DB::table('trent_book as a')
            ->select([
                DB::raw("COUNT(DISTINCT book_id) AS total")
            ])
            ->where('a.client_id', $this->client_id)
            ->where('a.user_id', $user->id)
            ->where('a.flag_end', 'N')
            ->get();
        
        $book   = $query_book[0]->total ?? $rent_book;

        // $queries = DB::getQueryLog();
        // for($q = 0; $q < count($queries); $q++) {
        //     $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
        //     $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
        //     $logs->write('SQL', $sql);
        // }
        // $logs->write(__FUNCTION__, "STOP\r\n");

        if($book < $rent_book){
            return response()->json([
               'code' => '1',
               'message' => 'Ok',
            ], 200);
        }

        return response()->json([
            'code' => '2',
            'message' => 'Kuota Pinjaman Buku Anda Sudah Habis!',
        ], 200);
    }

    public function ReturnBook(Request $request)
    {
        Carbon::setLocale('id');
        $user = auth()->user();
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, "START");
        DB::enableQueryLog();

        $now        = Carbon::now('Asia/Jakarta');
        $date       = $now->format('Y-m-d');
        $return     = DB::table('trent_book')
                    ->where('user_id', $user->id)
                    ->where('client_id', $this->client_id)
                    ->where('book_id', $request->pdfToken)
                    ->update([
                        'flag_end'  => 'Y',
                        'updated_at' => $now
                    ]);

        $queries = DB::getQueryLog();
        for($q = 0; $q < count($queries); $q++) {
            $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
            $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
            $logs->write('SQL', $sql);
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        if($return){
            return response()->json([
               'code' => '1',
               'message' => 'Berhasil Kembalikan Buku!',
            ], 200);
        }

        return response()->json([
            'code' => '0',
            'message' => 'Gagal Kembalikan Buku!',
        ], 200);
    }

    public function RentHistory()
    {
        $user = auth()->user();
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $results = [];
        try {
            DB::enableQueryLog();

            $results = DB::table('trent_book as a')
                ->select([
                    'a.book_id',
                    'b.title',
                    'a.start_date',
                    'a.end_date',
                    'a.flag_end',
                    'b.cover'
                ])
                ->join('tbook as b', 'a.book_id', '=', 'b.book_id')
                ->where('a.client_id', $this->client_id)
                ->where('a.user_id', $user->id)
                ->get();

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $queries[$q]['query']);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        return DataTables::of($results)
            ->escapeColumns()
            ->editColumn('start_date', function ($value) {
                return Carbon::parse($value->start_date)->toDateTimeString();
            })
            ->editColumn('end_date', function ($value) {
                return Carbon::parse($value->end_date)->toDateTimeString();
            })
            ->addIndexColumn()
            ->toJson();
    }
}
