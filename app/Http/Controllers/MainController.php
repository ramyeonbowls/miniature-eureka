<?php

namespace App\Http\Controllers;

use App\Logs;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        if($user && $user->role == 'member'){
            return response()->json([
               'name' => $user->name,
            ], 200);
        }

        return response()->json([
            'name' => '',
        ], 200);
    }
    
    public function getBukuPopuler()
    {
        $results = [];

        $sql = DB::table('tbook as a')
            ->select([
                'a.isbn',
                'a.title',
                'a.sinopsis',
                'a.filename',
                'a.cover as image',
                'a.writer'
            ])
            ->orderBy('createdate', 'desc')
            ->take(8)
            ->get();

        foreach ($sql as $i => $value) {
            $results[$i]['isbn']        = $value->isbn;
            $results[$i]['title']       = $value->title;
            $results[$i]['sinopsis']    = $value->sinopsis;
            $results[$i]['filename']    = $value->filename;
            $results[$i]['image']       = ( isset($value->image) && file_exists(public_path('/images/cover/'. $value->image)) ) ? "/images/cover/".$value->image : '/images/cover/default-cover.jpg';
            $results[$i]['writer']      = $value->writer;
        }

        return response()->json($results, 200);
    }
    
    public function getBuku()
    {
        $results = [];

        $sql = DB::table('tbook as a')
            ->select([
                'a.isbn',
                'a.title',
                'a.sinopsis',
                'a.filename',
                'a.cover as image',
                'a.writer'
            ])
            ->get();

        foreach ($sql as $i => $value) {
            $results[$i]['isbn']        = $value->isbn;
            $results[$i]['title']       = $value->title;
            $results[$i]['sinopsis']    = $value->sinopsis;
            $results[$i]['filename']    = $value->filename;
            $results[$i]['image']       = ( isset($value->image) && file_exists(public_path('/images/cover/'. $value->image)) ) ? "/images/cover/".$value->image : '/images/cover/default-cover.jpg';
            $results[$i]['writer']      = $value->writer;
        }

        return response()->json($results, 200);
    }
}
