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
use Symfony\Component\HttpFoundation\StreamedResponse;

class AudioBookController extends Controller
{
    protected $client_id = '';
    public function __construct()
    {
        $this->middleware('auth');
        $this->client_id = config('app.client_id', '');
    }

    public function streamAudio(Request $request)
    {
        $book_id = $request->input('book_id');
        $book = DB::table(DB::raw("(
                SELECT
                    'A1' book_id,
                    'Alexander Agung yang Pemberani.MP3' filename
                UNION ALL
                SELECT
                    'A2' book_id,
                    'Pangeran dari Jerman yang Baik Hati.MP3' filename
                UNION ALL
                SELECT
                    'A3' book_id,
                    'Lulu dan Bebe - Mencuri Pistol.mp3' filename
            ) as src"))
            ->where('book_id', $book_id)
            ->select('filename')
            ->first();
        $file = $book->filename;

        $filePath = 'private/audiobooks/' . $file;
        if (!Storage::exists($filePath)) {
            abort(404, 'File audio tidak ditemukan.');
        }

        $fullPath = Storage::path($filePath);
        $mime = 'audio/mpeg';
        $size = filesize($fullPath);

        $start = 0;
        $length = $size;
        $headers = [
            'Content-Type' => $mime,
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
        ];

        if ($request->headers->has('Range')) {
            preg_match('/bytes=(\d+)-(\d*)/', $request->header('Range'), $matches);
            $start = intval($matches[1]);
            $end = isset($matches[2]) && is_numeric($matches[2]) ? intval($matches[2]) : ($size - 1);
            $length = $end - $start + 1;

            $headers['Content-Range'] = "bytes $start-$end/$size";
            $headers['Content-Length'] = $length;

            $status = 206;
        } else {
            $headers['Content-Length'] = $size;
            $status = 200;
        }

        return new StreamedResponse(function () use ($fullPath, $start, $length) {
            $handle = fopen($fullPath, 'rb');
            fseek($handle, $start);
            $buffer = 1024 * 8;
            $bytesSent = 0;

            while (!feof($handle) && $bytesSent < $length) {
                $readLength = min($buffer, $length - $bytesSent);
                echo fread($handle, $readLength);
                $bytesSent += $readLength;
                flush();
            }

            fclose($handle);
        }, $status, $headers);
    }

    public function ReadAudioCheck(Request $request)
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
