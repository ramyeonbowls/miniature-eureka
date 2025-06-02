<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $book = DB::table(DB::raw('(select "Abu Dzar Al Ghifari.mp4" as filename) as dummy'))
            ->select('filename')
            ->get();
        $file = $book[0]->filename;

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
}
