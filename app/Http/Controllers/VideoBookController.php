<?php

namespace App\Http\Controllers;

use App\Logs;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class VideoBookController extends Controller
{
    protected $client_id = '';
    public function __construct()
    {
        $this->middleware('auth');
        $this->client_id = config('app.client_id', '');
    }

    public function streamVideo(Request $request)
    {
        $book_id = $request->input('book_id');
        $book = DB::table(DB::raw("(
                SELECT
                    '19d36c7a-449a-4561-b5e3-592341591587' book_id,
                    'Abu Ubaidah bin Al Jarrah.mp4' filename
                UNION ALL
                SELECT
                    '5de8a187-555f-4d36-94dc-39bdfae442e2' book_id,
                    'Abu Dzar Al Ghifari.mp4' filename
                UNION ALL
                SELECT
                    'b8f74377-33ac-4256-a267-2e607934def4' book_id,
                    'Bilal bin Rabah.mp4' filename
            ) as src"))
            ->where('book_id', $book_id)
            ->select('filename')
            ->first();
        $file = $book->filename;

        $filePath = 'private/videobooks/' . $file;
        $filename = explode('.', basename($filePath))[0];
        if (!Storage::exists($filePath)) {
            abort(404, 'File video tidak ditemukan.');
        }

        $encryptedContent = Storage::get($filePath);

        // try {
        //     $decryptedContent = Crypt::decrypt($encryptedContent);
        // } catch (\Exception $e) {
        //     abort(500, 'Gagal mendekripsi file audio.');
        // }

        return response($encryptedContent, 200)
            ->header('Content-Type', 'video/mp4')
            ->header('Content-Disposition', 'inline; filename="' . basename($filename) . '"')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate')
            ->header('Accept-Ranges', 'bytes');
    }

    public function ReadVideoCheck(Request $request)
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

        $cek_stock = DB::table(DB::raw('(select 4 as remaining ) as dummy'))
        ->select('remaining')
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
}
