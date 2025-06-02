<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $book = DB::table(DB::raw('(select "Alexander Agung yang Pemberani.MP3" as filename) as dummy'))
        ->select('filename')
        ->get();
        $file = $book[0]->filename;

        $filePath = 'private/audiobooks/' . $file;
        if (!Storage::exists($filePath)) {
            abort(404, 'File audio tidak ditemukan.');
        }

        $fullPath = Storage::path($filePath); // Ambil path fisik file
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
            // Contoh: Range: bytes=12345-
            preg_match('/bytes=(\d+)-(\d*)/', $request->header('Range'), $matches);
            $start = intval($matches[1]);
            $end = isset($matches[2]) && is_numeric($matches[2]) ? intval($matches[2]) : ($size - 1);
            $length = $end - $start + 1;

            $headers['Content-Range'] = "bytes $start-$end/$size";
            $headers['Content-Length'] = $length;

            $status = 206; // Partial Content
        } else {
            $headers['Content-Length'] = $size;
            $status = 200;
        }

        // Kirim sebagai stream agar efisien dan kompatibel
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
}
