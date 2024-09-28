<?php

namespace App\Http\Controllers;

use App\Logs;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
        $results = DB::table('tbook as a')
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
            ->get()
            ->map(function ($value) {
                return [
                    'isbn'     => $value->isbn,
                    'title'    => $value->title,
                    'sinopsis' => $value->sinopsis,
                    'filename' => $value->filename,
                    'image'    => (isset($value->image) && file_exists(public_path('/images/cover/' . $value->image))) 
                                    ? '/images/cover/' . $value->image 
                                    : '/images/cover/default-cover.jpg',
                    'writer'   => $value->writer
                ];
            });

        return response()->json($results, 200);
    }
    
    public function getBook(Request $request)
    {
        // $logs = new Logs( Arr::last(explode("\\", get_class())) );
        // $logs->write(__FUNCTION__, "START");
        // DB::enableQueryLog();

        $category   = $request->categories ?? [];
        $parameter  = $request->search ?? '';

        $results = DB::table('tbook as a')
            ->select([
                'a.isbn',
                'a.title',
                'a.sinopsis',
                'a.filename',
                'a.cover as image',
                'a.writer'
            ])
            ->when($parameter != '', function($query) use ($parameter) {
				$query->where('a.writer', 'LIKE', '%' . $parameter . '%')
                    ->orWhere('a.isbn', 'LIKE', '%' . $parameter . '%')
                    ->orWhere('a.title', 'LIKE', '%' . $parameter . '%');
			})
            ->when(count($category)>0, function($query) use ($category) {
				$query->whereIn('a.category_id', $category);
			})
            ->get()
            ->map(function ($value) {
                return [
                    'isbn'     => $value->isbn,
                    'title'    => $value->title,
                    'sinopsis' => $value->sinopsis,
                    'filename' => $value->filename,
                    'image'    => (isset($value->image) && file_exists(public_path('/images/cover/' . $value->image))) 
                                    ? '/images/cover/' . $value->image 
                                    : '/images/cover/default-cover.jpg',
                    'writer'   => $value->writer
                ];
            });

        // $queries = DB::getQueryLog();
        // for($q = 0; $q < count($queries); $q++) {
        //     $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
        //     $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
        //     $logs->write('SQL', $sql);
        // }

        // $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($results, 200);
    }
    
    public function getDetail(Request $request)
    {
        $isbn = $request->id;

        $results = DB::table('tbook as a')
            ->select([
                'a.isbn',
                'a.title',
                'a.sinopsis',
                'a.filename',
                'a.cover as image',
                'a.writer',
                'a.year',
                'a.page'
            ])
            ->where('a.isbn','=', $isbn)
            ->first();

        if ($results) {
            $results->image = (isset($results->image) && file_exists(public_path('/images/cover/' . $results->image))) ? "/images/cover/" . $results->image : '/images/cover/default-cover.jpg';
        }

        return response()->json($results, 200);
    }

    public function getCategory()
    {
        $results = DB::table('tbook_category as a')
            ->select([
                'a.id',
                'a.description'
            ])
            ->get();

        return response()->json($results, 200);
    }

    public function getBanner()
    {
        $client_id = env('APP_CLIENT_ID') ?? 'pustakadigital'; 

        $results = DB::table('tbanner as a')
            ->select([
                'a.id',
                'a.description',
                'a.file as image',
                'a.disp_type'
            ])
            ->where('a.client_id','=', $client_id)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->map(function ($value) {
                return [
                    'id'            => $value->id,
                    'description'   => $value->description,
                    'display'       => $value->disp_type,
                    'image'         => (isset($value->image) && file_exists(public_path('/images/banner/' . $value->image))) 
                                    ? '/images/banner/' . $value->image 
                                    : '/images/banner/banner1.jpg'
                ];
            });

        return response()->json($results, 200);
    }

    public function getArticle(Request $request)
    {
        $category = $request->id;
        $client_id = env('APP_CLIENT_ID') ?? 'pustakadigital'; 

        $results = DB::table('tfitur as a')
            ->select([
                'a.id',
                'a.title',
                'a.description',
                'a.author',
                'a.file as image',
                'a.created_at as published_at',
            ])
            ->where('a.client_id','=', $client_id)
            ->where('a.category','=', $category)
            ->where('a.flag_aktif','=', 'Y')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->map(function ($value) {
                return [
                    'id'            => $value->id,
                    'title'         => $value->title,
                    'content'       => $value->description,
                    'author'        => $value->author,
                    'published_at'  => $value->published_at,
                    'image'         => (isset($value->image) && file_exists(public_path('/images/news/' . $value->image))) 
                                    ? '/images/news/' . $value->image 
                                    : '/images/news/default-news.jpg'
                ];
            });

        return response()->json($results, 200);
    }

    public function getAllArticle()
    {
        $client_id = env('APP_CLIENT_ID') ?? 'pustakadigital'; 

        $tajuk_utama = DB::table('tfitur as a')
            ->select([
                'a.id',
                'a.title',
                'a.description',
                'a.author',
                'a.file as image',
                'a.created_at as published_at',
                'a.category'
            ])
            ->where('a.client_id','=', $client_id)
            ->where('a.category','=', 'TU')
            ->where('a.flag_aktif','=', 'Y')
            ->orderBy('created_at', 'DESC')
            ->limit(4)
            ->get()
            ->map(function ($value) {
                return [
                    'id'            => $value->id,
                    'title'         => $value->title,
                    'content'       => $value->description,
                    'author'        => $value->author,
                    'published_at'  => $value->published_at,
                    'category'      => $value->category,
                    'image'         => (isset($value->image) && file_exists(public_path('/images/news/' . $value->image))) 
                                    ? '/images/news/' . $value->image 
                                    : '/images/news/default-news.jpg'
                ];
            });

        $wawasan = DB::table('tfitur as a')
            ->select([
                'a.id',
                'a.title',
                'a.description',
                'a.author',
                'a.file as image',
                'a.created_at as published_at',
                'a.category'
            ])
            ->where('a.client_id','=', $client_id)
            ->where('a.category','=', 'WA')
            ->where('a.flag_aktif','=', 'Y')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->map(function ($value) {
                return [
                    'id'            => $value->id,
                    'title'         => $value->title,
                    'content'       => $value->description,
                    'author'        => $value->author,
                    'published_at'  => $value->published_at,
                    'category'      => $value->category,
                    'image'         => (isset($value->image) && file_exists(public_path('/images/news/' . $value->image))) 
                                    ? '/images/news/' . $value->image 
                                    : '/images/news/default-news.jpg'
                ];
            });

        $frasa = DB::table('tfitur as a')
            ->select([
                'a.id',
                'a.title',
                'a.description',
                'a.author',
                'a.file as image',
                'a.created_at as published_at',
                'a.category'
            ])
            ->where('a.client_id','=', $client_id)
            ->where('a.category','=', 'FR')
            ->where('a.flag_aktif','=', 'Y')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->map(function ($value) {
                return [
                    'id'            => $value->id,
                    'title'         => $value->title,
                    'kata'          => $value->description,
                    'by'            => $value->author,
                    'published_at'  => $value->published_at,
                    'category'      => $value->category,
                    'image'         => (isset($value->image) && file_exists(public_path('/images/news/' . $value->image))) 
                                    ? '/images/news/' . $value->image 
                                    : '/images/news/anonim.jpg'
                ];
            });

        $review_buku = DB::table('tfitur as a')
            ->select([
                'a.id',
                'a.title',
                'a.description',
                'a.author',
                'a.file as image',
                'a.created_at as published_at',
                'a.category'
            ])
            ->where('a.client_id','=', $client_id)
            ->where('a.category','=', 'RB')
            ->where('a.flag_aktif','=', 'Y')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->map(function ($value) {
                return [
                    'id'            => $value->id,
                    'title'         => $value->title,
                    'content'       => $value->description,
                    'author'        => $value->author,
                    'published_at'  => $value->published_at,
                    'category'      => $value->category,
                    'image'         => (isset($value->image) && file_exists(public_path('/images/news/' . $value->image))) 
                                    ? '/images/news/' . $value->image 
                                    : '/images/news/default-news.jpg'
                ];
            });

        $layar_penulis = DB::table('tfitur as a')
            ->select([
                'a.id',
                'a.title',
                'a.description',
                'a.author',
                'a.file as image',
                'a.created_at as published_at',
                'a.category'
            ])
            ->where('a.client_id','=', $client_id)
            ->where('a.category','=', 'LP')
            ->where('a.flag_aktif','=', 'Y')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->map(function ($value) {
                return [
                    'id'            => $value->id,
                    'title'         => $value->title,
                    'content'       => $value->description,
                    'author'        => $value->author,
                    'published_at'  => $value->published_at,
                    'category'      => $value->category,
                    'image'         => (isset($value->image) && file_exists(public_path('/images/news/' . $value->image))) 
                                    ? '/images/news/' . $value->image 
                                    : '/images/news/default-news.jpg'
                ];
            });

        $titik_fokus = DB::table('tfitur as a')
            ->select([
                'a.id',
                'a.title',
                'a.description',
                'a.author',
                'a.file as image',
                'a.created_at as published_at',
                'a.category'
            ])
            ->where('a.client_id','=', $client_id)
            ->where('a.category','=', 'TF')
            ->where('a.flag_aktif','=', 'Y')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->map(function ($value) {
                return [
                    'id'            => $value->id,
                    'title'         => $value->title,
                    'content'       => $value->description,
                    'author'        => $value->author,
                    'published_at'  => $value->published_at,
                    'category'      => $value->category,
                    'image'         => (isset($value->image) && file_exists(public_path('/images/news/' . $value->image))) 
                                    ? '/images/news/' . $value->image 
                                    : '/images/news/default-news.jpg'
                ];
            });

        $humoria = DB::table('tfitur as a')
            ->select([
                'a.id',
                'a.title',
                'a.description',
                'a.author',
                'a.file as image',
                'a.created_at as published_at',
                'a.category'
            ])
            ->where('a.client_id','=', $client_id)
            ->where('a.category','=', 'HU')
            ->where('a.flag_aktif','=', 'Y')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->map(function ($value) {
                return [
                    'id'            => $value->id,
                    'title'         => $value->title,
                    'content'       => $value->description,
                    'author'        => $value->author,
                    'published_at'  => $value->published_at,
                    'category'      => $value->category,
                    'image'         => (isset($value->image) && file_exists(public_path('/images/news/' . $value->image))) 
                                    ? '/images/news/' . $value->image 
                                    : '/images/news/default-news.jpg'
                ];
            });

        $results['TU'] = $tajuk_utama ?? [];
        $results['WA'] = $wawasan ?? [];
        $results['FR'] = $frasa ?? [];
        $results['RB'] = $review_buku ?? [];
        $results['LP'] = $layar_penulis ?? [];
        $results['TF'] = $titik_fokus ?? [];
        $results['HU'] = $humoria ?? [];

        return response()->json($results, 200);
    }

    public function getDetailArticle(Request $request)
    {
        $category   = $request->category;
        $id         = $request->id;
        $client_id = env('APP_CLIENT_ID') ?? 'pustakadigital'; 

        $results = DB::table('tfitur as a')
            ->select([
                'a.id',
                'a.title',
                'a.description',
                'a.author',
                'a.file as image',
                'a.created_at as published_at',
            ])
            ->where('a.client_id','=', $client_id)
            ->where('a.category','=', $category)
            ->where('a.id','=', $id)
            ->where('a.flag_aktif','=', 'Y')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->map(function ($value) {
                return [
                    'id'            => $value->id,
                    'title'         => $value->title,
                    'content'       => $value->description,
                    'author'        => $value->author,
                    'published_at'  => $value->published_at,
                    'image'         => (isset($value->image) && file_exists(public_path('/images/news/' . $value->image))) 
                                    ? '/images/news/' . $value->image 
                                    : '/images/news/default-news.jpg'
                ];
            });

        return response()->json($results, 200);
    }
}
