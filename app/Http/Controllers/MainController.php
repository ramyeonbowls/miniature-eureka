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
    protected $client_id = '';
    public function __construct()
    {
      //   $this->middleware('auth');
      $this->client_id = config('app.client_id', '');
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
        $dibacaBooksQuery = DB::table('ttrx_read as a')
            ->select([
                'b.book_id',
                'a.isbn',
                'b.title',
                'b.sinopsis',
                'b.cover as image',
                'b.writer',
                DB::raw('SUM(TIMESTAMPDIFF(SECOND, a.start_read, a.end_read)) as total_seconds'),
                DB::raw('SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, a.start_read, a.end_read))) as total_time')
            ])
            ->join('tbook as b', 'a.isbn', '=', 'b.isbn')
            ->where('a.client_id', $this->client_id)
            ->groupBy('a.isbn')
            ->orderBy('total_seconds', 'desc')
            ->limit(10);

        $dibacaBooks    = $dibacaBooksQuery->get();
        $results        = $dibacaBooksQuery;

        if ($dibacaBooks->count() < 10) {
            $readIsbns = $dibacaBooks->pluck('isbn')->toArray();

            $remainingBooks = DB::table('tmapping_book as a')
                ->select([
                    'b.book_id',
                    'b.isbn',
                    'b.title',
                    'b.sinopsis',
                    'b.cover as image',
                    'b.writer',
                    DB::raw('0 as total_seconds'),
                    DB::raw('0 as total_time')
                ])
                ->join('tbook as b', function($join) {
                    $join->on('a.book_id', '=', 'b.book_id')
                        ->on('a.isbn', '=', 'b.isbn');
                })
                ->where('a.client_id', '=', $this->client_id)
                ->whereNotIn('b.isbn', $readIsbns)
                ->limit(10 - $dibacaBooks->count());

            $results = $results->unionAll($remainingBooks);
        }

        $finalResults = $results
            ->get()
            ->map(function ($value) {
                return [
                    'isbn'     => $value->isbn,
                    'title'    => $value->title,
                    'sinopsis' => $value->sinopsis,
                    'image'    => (isset($value->image) && file_exists(public_path('/images/cover/' . $value->image))) 
                                    ? '/images/cover/' . $value->image 
                                    : '/images/cover/default-cover.jpg',
                    'writer'   => $value->writer
                ];
            });
        

        return response()->json($finalResults, 200);
    }
    
    public function getBook(Request $request)
    {
        $logs = new Logs( Arr::last(explode("\\", get_class())) );
        $logs->write(__FUNCTION__, "START");
        DB::enableQueryLog();

        $category   = $request->categories ?? [];
        $parameter  = $request->search ?? '';

        $results = DB::table('tmapping_book as a')
            ->select([
                'b.book_id',
                'a.copy',
                'b.isbn',
                'b.title',
                'b.sinopsis',
                'b.cover as image',
                'b.writer',
                'b.age',
                'c.description as category'
            ])
            ->join('tbook as b', function($join) {
                $join->on('a.book_id', '=', 'b.book_id')
                    ->on('a.isbn', '=', 'b.isbn');
            })
            ->join('tbook_category as c', function($join) {
                $join->on('b.category_id', '=', 'c.id');
            })
            ->when($parameter != '', function($query) use ($parameter) {
				$query->where('b.writer', 'LIKE', '%' . $parameter . '%')
                    ->orWhere('b.isbn', 'LIKE', '%' . $parameter . '%')
                    ->orWhere('b.title', 'LIKE', '%' . $parameter . '%');
			})
            ->when(count($category)>0, function($query) use ($category) {
				$query->whereIn('b.category_id', $category);
			})
            ->where('a.client_id', '=', $this->client_id)
            ->get()
            ->map(function ($value) {
                return [
                    'isbn'     => $value->isbn,
                    'title'    => $value->title,
                    'sinopsis' => $value->sinopsis,
                    'image'    => (isset($value->image) && file_exists(public_path('/images/cover/' . $value->image))) 
                                    ? '/images/cover/' . $value->image 
                                    : '/images/cover/default-cover.jpg',
                    'writer'   => $value->writer
                ];
            });

        $queries = DB::getQueryLog();
        for($q = 0; $q < count($queries); $q++) {
            $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
            $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
            $logs->write('SQL', $sql);
        }

        $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($results, 200);
    }
    
    public function getDetail(Request $request)
    {
        $isbn = $request->id;

        $logs = new Logs( Arr::last(explode("\\", get_class())) );
        $logs->write(__FUNCTION__, "START");
        DB::enableQueryLog();

        $results = DB::table('tmapping_book as a')
            ->select([
                'b.book_id',
                'a.copy',
                'b.isbn',
                'b.title',
                'b.sinopsis',
                'b.cover as image',
                'b.writer',
                'b.age',
                'c.description as category',
                'b.year',
                'b.page',
                DB::raw("CASE WHEN COUNT(DISTINCT d.isbn) > 0 THEN a.copy - COUNT(DISTINCT d.isbn) ELSE a.copy END as remaining")
            ])
            ->join('tbook as b', function($join) {
                $join->on('a.book_id', '=', 'b.book_id')
                    ->on('a.isbn', '=', 'b.isbn');
            })
            ->join('tbook_category as c', function($join) {
                $join->on('b.category_id', '=', 'c.id');
            })
            ->leftJoin(DB::raw("(SELECT isbn, COUNT(DISTINCT isbn) as dibaca FROM ttrx_read WHERE client_id = '".$this->client_id."' AND flag_end = 'Y' GROUP BY isbn) as d"), function($join) {
                $join->on('b.isbn', '=', 'd.isbn');
            })
            ->where('a.client_id', '=', $this->client_id)
            ->groupBy([
                'b.book_id',
                'a.copy',
                'b.isbn',
                'b.title',
                'b.sinopsis',
                'b.cover',
                'b.writer',
                'b.age',
                'c.description',
                'b.year',
                'b.page'
            ])
            ->first();

        if ($results) {
            $results->image = (isset($results->image) && file_exists(public_path('/images/cover/' . $results->image))) ? "/images/cover/" . $results->image : '/images/cover/default-cover.jpg';
        }

        $queries = DB::getQueryLog();
        for($q = 0; $q < count($queries); $q++) {
            $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
            $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
            $logs->write('SQL', $sql);
        }

        $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($results, 200);
    }

    public function getCategory()
    {
        $results = DB::table('tmapping_book as a')
        ->select('c.id', 'c.description')
        ->join('tbook as b', function ($join) {
            $join->on('a.book_id', '=', 'b.book_id')
            ->on('a.isbn', '=', 'b.isbn');
        })
        ->join('tbook_category as c', 'b.category_id', '=', 'c.id')
        ->where('a.client_id', '=', $this->client_id)
        ->distinct()
        ->orderBy('c.description', 'ASC')
        ->get();

        return response()->json($results, 200);
    }

    public function getBanner()
    {
        $results = DB::table('tbanner as a')
            ->select([
                'a.id',
                'a.description',
                'a.file as image',
                'a.disp_type'
            ])
            ->where('a.client_id','=', $this->client_id)
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

        $results = DB::table('tfitur as a')
            ->select([
                'a.id',
                'a.title',
                'a.description',
                'a.author',
                'a.file as image',
                'a.created_at as published_at',
            ])
            ->where('a.client_id','=', $this->client_id)
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
            ->where('a.client_id','=', $this->client_id)
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
            ->where('a.client_id','=', $this->client_id)
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
            ->where('a.client_id','=', $this->client_id)
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
            ->where('a.client_id','=', $this->client_id)
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
            ->where('a.client_id','=', $this->client_id)
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
            ->where('a.client_id','=', $this->client_id)
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
            ->where('a.client_id','=', $this->client_id)
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

        $results = DB::table('tfitur as a')
            ->select([
                'a.id',
                'a.title',
                'a.description',
                'a.author',
                'a.file as image',
                'a.created_at as published_at',
            ])
            ->where('a.client_id','=', $this->client_id)
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
