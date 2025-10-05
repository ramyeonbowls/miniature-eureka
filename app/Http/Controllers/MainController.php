<?php

namespace App\Http\Controllers;

use App\Logs;
use Carbon\Carbon;
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
            $attr = DB::table('tattr_member as a')
                ->select([
                    'a.photo as avatar',
                ])
                ->where('a.client_id', $this->client_id)
                ->where('a.id', $user->id)
                ->get();

            return response()->json([
               'name'   => $user->name,
               'avatar' => (isset($attr[0]->avatar) && file_exists(public_path('/storage/images/profile/' . $attr[0]->avatar)) ? '/storage/images/profile/' . $attr[0]->avatar : '/storage/images/profile/default.jpg')
            ], 200);
        }

        return response()->json([
            'name' => '',
            'avatar' => ''
        ], 200);
    }
    
    public function getBukuPopuler()
    {
        $dibacaBooksQuery = DB::table('ttrx_read as a')
            ->select([
                'b.book_id',
                'b.isbn',
                'b.title',
                'b.sinopsis',
                'b.cover as image',
                'b.writer',
                DB::raw('SUM(TIMESTAMPDIFF(SECOND, a.start_read, a.end_read)) as total_seconds'),
                DB::raw('SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, a.start_read, a.end_read))) as total_time')
            ])
            ->join('tbook as b', 'a.book_id', '=', 'b.book_id')
            ->where('a.client_id', $this->client_id)
            ->groupBy([
                'b.book_id',
                'b.isbn',
                'b.title',
                'b.sinopsis',
                'b.cover',
                'b.writer'
            ])
            ->orderBy('total_seconds', 'desc')
            ->limit(8);

        $dibacaBooks    = $dibacaBooksQuery->get();
        $results        = $dibacaBooksQuery;

        if ($dibacaBooks->count() < 8) {
            $readIsbns = $dibacaBooks->pluck('book_id')->toArray();

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
                    $join->on('a.book_id', '=', 'b.book_id');
                })
                ->where('a.client_id', '=', $this->client_id)
                ->whereNotIn('b.book_id', $readIsbns)
                ->limit(8 - $dibacaBooks->count());

            $results = $results->unionAll($remainingBooks);
        }

        $finalResults = $results
            ->get()
            ->map(function ($value) {
                return [
                    'isbn'     => $value->isbn,
                    'title'    => $value->title,
                    'sinopsis' => $value->sinopsis,
                    'image'    => (isset($value->image) && file_exists(public_path('/storage/covers/' . $value->image))) 
                                    ? '/storage/covers/' . $value->image 
                                    : '/storage/covers/default-cover.jpg',
                    'writer'   => $value->writer
                ];
            });
        

        return response()->json($finalResults, 200);
    }
    
    public function getBook(Request $request)
    {
        // $logs = new Logs( Arr::last(explode("\\", get_class())) );
        // $logs->write(__FUNCTION__, "START");
        // DB::enableQueryLog();

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
                $join->on('a.book_id', '=', 'b.book_id');
            })
            ->join('tbook_category as c', function($join) {
                $join->on('b.category_id', '=', 'c.id');
            })
            ->when($parameter != '', function($query) use ($parameter) {
				$query->where(function($query) use ($parameter) {
					$query->where('b.writer', 'LIKE', '%' . $parameter . '%')
						  ->orWhere('b.isbn', 'LIKE', '%' . $parameter . '%')
						  ->orWhere('b.title', 'LIKE', '%' . $parameter . '%');
				});
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
                    'image'    => (isset($value->image) && file_exists(public_path('/storage/covers/' . $value->image))) 
                                    ? '/storage/covers/' . $value->image 
                                    : '/storage/covers/default-cover.jpg',
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
    
    public function getNewCollection()
    {
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
                $join->on('a.book_id', '=', 'b.book_id');
            })
            ->join('tbook_category as c', function($join) {
                $join->on('b.category_id', '=', 'c.id');
            })
            ->where('a.client_id', '=', $this->client_id)
            ->limit(10)
            ->orderBy('a.created_at', 'asc')
            ->get()
            ->map(function ($value) {
                return [
                    'isbn'     => $value->isbn,
                    'title'    => $value->title,
                    'sinopsis' => $value->sinopsis,
                    'image'    => (isset($value->image) && file_exists(public_path('/storage/covers/' . $value->image))) 
                                    ? '/storage/covers/' . $value->image 
                                    : '/storage/covers/default-cover.jpg',
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
        $user = auth()->user();

        // $logs = new Logs( Arr::last(explode("\\", get_class())) );
        // $logs->write(__FUNCTION__, "START");
        // DB::enableQueryLog();

        $query = DB::table('tmapping_book as a')
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
                DB::raw("a.copy - IFNULL(d.total, 0) as remaining"),
				'f.description as publisher'
            ])
            ->join('tbook as b', function($join) {
                $join->on('a.book_id', '=', 'b.book_id');
            })
            ->join('tbook_category as c', function($join) {
                $join->on('b.category_id', '=', 'c.id');
            })
            ->join('tpublisher as f', function($join) {
                $join->on('b.publisher_id', '=', 'f.id');
            })
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
                        ) sr
                        group by sr.book_id, sr.user_id
                    )src
                    GROUP BY src.book_id) as d"), function($join) {
                $join->on('b.book_id', '=', 'd.book_id');
            });

            if ($user) {
                $query->selectRaw("CASE WHEN IFNULL(e.book_id, '') = '' THEN 'N' ELSE 'Y' END as rent")
                ->leftJoin('trent_book as e', function($join) use ($user) {
                    $join->on('b.book_id', '=', 'e.book_id')
                        ->where('e.flag_end', '=', 'N')
                        ->where('e.user_id', '=', $user->id);
                });
            }else{
                $query->selectRaw("'N' as rent");
            }

            $results = $query->where('a.client_id', '=', $this->client_id)
            ->where('b.isbn', '=', $isbn)
            ->first();

        if ($results) {
            $results->image = (isset($results->image) && file_exists(public_path('/storage/covers/' . $results->image))) ? "/storage/covers/" . $results->image : '/storage/covers/default-cover.jpg';
        }

        // $queries = DB::getQueryLog();
        // for($q = 0; $q < count($queries); $q++) {
        //     $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
        //     $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
        //     $logs->write('SQL', $sql);
        // }
        // $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($results, 200);
    }

    public function getCategory()
    {
        $results = DB::table('tmapping_book as a')
        ->select(
			'c.id',
			'c.description',
			DB::raw("count(distinct a.book_id) as total")
		)
        ->join('tbook as b', function ($join) {
            $join->on('a.book_id', '=', 'b.book_id');
        })
        ->join('tbook_category as c', 'b.category_id', '=', 'c.id')
        ->where('a.client_id', '=', $this->client_id)
        ->distinct()
		->groupBy('c.id', 'c.description')
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
                    'image'         => (isset($value->image) && file_exists(public_path('/storage/images/banner/' . $value->image))) 
                                    ? '/storage/images/banner/' . $value->image 
                                    : '/storage/images/banner/banner1.jpg'
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
                    'image'         => (isset($value->image) && file_exists(public_path('/storage/images/news/' . $value->image))) 
                                    ? '/storage/images/news/' . $value->image 
                                    : '/storage/images/news/default-news.jpg'
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
                    'image'         => (isset($value->image) && file_exists(public_path('/storage/images/news/' . $value->image))) 
                                    ? '/storage/images/news/' . $value->image 
                                    : '/storage/images/news/default-news.jpg'
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
                    'image'         => (isset($value->image) && file_exists(public_path('/storage/images/news/' . $value->image))) 
                                    ? '/storage/images/news/' . $value->image 
                                    : '/storage/images/news/default-news.jpg'
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
                    'image'         => (isset($value->image) && file_exists(public_path('/storage/images/news/' . $value->image))) 
                                    ? '/storage/images/news/' . $value->image 
                                    : '/storage/images/news/anonim.jpg'
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
                    'image'         => (isset($value->image) && file_exists(public_path('/storage/images/news/' . $value->image))) 
                                    ? '/storage/images/news/' . $value->image 
                                    : '/storage/images/news/default-news.jpg'
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
                    'image'         => (isset($value->image) && file_exists(public_path('/storage/images/news/' . $value->image))) 
                                    ? '/storage/images/news/' . $value->image 
                                    : '/storage/images/news/default-news.jpg'
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
                    'image'         => (isset($value->image) && file_exists(public_path('/storage/images/news/' . $value->image))) 
                                    ? '/storage/images/news/' . $value->image 
                                    : '/storage/images/news/default-news.jpg'
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
                    'image'         => (isset($value->image) && file_exists(public_path('/storage/images/news/' . $value->image))) 
                                    ? '/storage/images/news/' . $value->image 
                                    : '/storage/images/news/default-news.jpg'
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
                    'image'         => (isset($value->image) && file_exists(public_path('/storage/images/news/' . $value->image))) 
                                    ? '/storage/images/news/' . $value->image 
                                    : '/storage/images/news/default-news.jpg'
                ];
            });

        return response()->json($results, 200);
    }

    public function getAppInfo()
    {
        $results = DB::table('tclient as a')
            ->select([
                'a.application_name',
            ])
            ->where('a.client_id', '=' , $this->client_id)
            ->get();

        return response()->json($results, 200);
    }

    public function getParam()
    {
		$parameter = ['reg_member', 'additional_features'];
        $results = DB::table('tparameter as a')
            ->select([
                'a.name',
                'a.value',
            ])
            ->where('a.client_id', '=' , $this->client_id)
            ->whereIn('a.name', $parameter)
            ->get()
			->keyBy('name')
			->map(function ($item) {
				return $item->value;
			});

        return response()->json($results, 200);
    }

	public function getDtQuiz()
    {
		// $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        // $logs->write(__FUNCTION__, 'START');
		// DB::enableQueryLog();

		$user = auth()->user();

        $results = DB::table('tquiz_h as a')
            ->select([
                'a.id',
                'a.title',
                'a.description',
                'a.start_date',
                'a.end_date',
				'b.name'
            ])
			->join('users as b', function ($join) {
				$join->on('a.client_id', '=', 'b.client_id')
				->on('a.created_by', '=', 'b.email');
			})
            ->where('a.client_id','=', $this->client_id)
            ->whereRaw("CONVERT(NOW(), DATE) BETWEEN a.start_date AND a.end_date")
            ->orderBy('a.created_at', 'DESC')
            ->get()
            ->map(function ($value) use ($user) {
				if($user){
					$cek_nilai	= $this->getResult($this->client_id, $value->id, $user->id);
					$nilai		= $cek_nilai->nilai;
					$finished	= ($cek_nilai->finished > 0 ? true : false);
				}else{
					$nilai		= 0;
					$finished	= false;
				}

                return [
                    'id'			=> $value->id,
                    'title'			=> $value->title,
                    'description'	=> $value->description,
                    'start_date'	=> $value->start_date,
                    'end_date'		=> $value->end_date,
                    'finished'		=> $finished,
                    'name'			=> $value->name
                ];
            });

		// $queries = DB::getQueryLog();
		// for($q = 0; $q < count($queries); $q++) {
		// 	$sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
		// 	$logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
		// 	$logs->write('SQL', $sql);
		// }

        return response()->json($results, 200);
    }

	public function getVideo()
    {
		// $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        // $logs->write(__FUNCTION__, 'START');
		// DB::enableQueryLog();

		$user = auth()->user();

        $results = DB::table('tvideo as a')
            ->select([
                'a.id',
                'a.title',
                'a.description',
                'a.file'
            ])
            ->where('a.client_id','=', $this->client_id)
            ->where('a.flag_aktif','=', 'Y')
            ->where('a.file','!=', '')
            ->get()
            ->map(function ($value) use ($user) {
				$url	= explode('https://www.youtube.com/embed/', $value->file)[1];
				$idv	= explode('"', $url)[0];
				$id		= "https://www.youtube.com/embed/".$idv."?enablejsapi=1";

                return [
                    'id'			=> $value->id,
                    'title'			=> $value->title,
                    'description'	=> $value->description,
                    'file'			=> $id != '' ? $id : ''
                ];
            });

		// $queries = DB::getQueryLog();
		// for($q = 0; $q < count($queries); $q++) {
		// 	$sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
		// 	$logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
		// 	$logs->write('SQL', $sql);
		// }

        return response()->json($results, 200);
    }

    public function getAudioBook(Request $request)
    {
        // $logs = new Logs( Arr::last(explode("\\", get_class())) );
        // $logs->write(__FUNCTION__, "START");
        // DB::enableQueryLog();

        $category   = $request->categories ?? [];
        $parameter  = $request->search ?? '';

        $results = DB::table('tbook as b')
            ->select([
                'b.book_id',
                DB::raw('4 as copy'),
                'b.isbn',
                'b.title',
                'b.sinopsis',
                'b.cover as image',
                'b.writer',
                'b.age',
                'c.description as category'
            ])
            ->join('tbook_category as c', function($join) {
                $join->on('b.category_id', '=', 'c.id');
            })
            ->join('tmapping_book as a', function($join) {
                $join->on('a.book_id', '=', 'b.book_id');
            })
            ->when($parameter != '', function($query) use ($parameter) {
				$query->where(function($query) use ($parameter) {
					$query->where('b.writer', 'LIKE', '%' . $parameter . '%')
						  ->orWhere('b.isbn', 'LIKE', '%' . $parameter . '%')
						  ->orWhere('b.title', 'LIKE', '%' . $parameter . '%');
				});
			})
            ->when(count($category)>0, function($query) use ($category) {
				$query->whereIn('b.category_id', $category);
			})
            ->where('a.client_id', '=', $this->client_id)
            ->whereRaw("b.book_id IN ('A1','A2','A3')")
            ->get()
            ->map(function ($value) {
                return [
                    'isbn'     => $value->isbn,
                    'title'    => $value->title,
                    'sinopsis' => $value->sinopsis,
                    'image'    => (isset($value->image) && file_exists(public_path('/storage/covers/' . $value->image))) 
                                    ? '/storage/covers/' . $value->image 
                                    : '/storage/covers/default-cover.jpg',
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

    public function getVideoBook(Request $request)
    {
        // $logs = new Logs( Arr::last(explode("\\", get_class())) );
        // $logs->write(__FUNCTION__, "START");
        // DB::enableQueryLog();

        $category   = $request->categories ?? [];
        $parameter  = $request->search ?? '';

        $results = DB::table('tbook as b')
            ->select([
                'b.book_id',
                DB::raw('4 as copy'),
                'b.isbn',
                'b.title',
                'b.sinopsis',
                'b.cover as image',
                'b.writer',
                'b.age',
                'c.description as category'
            ])
            ->join('tbook_category as c', function($join) {
                $join->on('b.category_id', '=', 'c.id');
            })
            ->join('tmapping_book as a', function($join) {
                $join->on('a.book_id', '=', 'b.book_id');
            })
            ->when($parameter != '', function($query) use ($parameter) {
				$query->where(function($query) use ($parameter) {
					$query->where('b.writer', 'LIKE', '%' . $parameter . '%')
						  ->orWhere('b.isbn', 'LIKE', '%' . $parameter . '%')
						  ->orWhere('b.title', 'LIKE', '%' . $parameter . '%');
				});
			})
            ->when(count($category)>0, function($query) use ($category) {
				$query->whereIn('b.category_id', $category);
			})
            ->where('a.client_id', '=', $this->client_id)
            ->whereRaw("b.book_id IN ('B1','B2','B3')")
            ->get()
            ->map(function ($value) {
                return [
                    'isbn'     => $value->isbn,
                    'title'    => $value->title,
                    'sinopsis' => $value->sinopsis,
                    'image'    => (isset($value->image) && file_exists(public_path('/storage/covers/' . $value->image))) 
                                    ? '/storage/covers/' . $value->image 
                                    : '/storage/covers/default-cover.jpg',
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

    public function getDetailVideoBook(Request $request)
    {
        $isbn = $request->id;
        $user = auth()->user();

        // $logs = new Logs( Arr::last(explode("\\", get_class())) );
        // $logs->write(__FUNCTION__, "START");
        // DB::enableQueryLog();

        $query = DB::table('tbook as b')
            ->select([
                'b.book_id',
                DB::raw('4 as copy'),
                'b.isbn',
                'b.title',
                'b.sinopsis',
                'b.cover as image',
                'b.writer',
                'b.age',
                'c.description as category',
                'b.year',
                'b.page',
                DB::raw("4 - IFNULL(d.total, 0) as remaining"),
				'f.description as publisher'
            ])
            ->join('tbook_category as c', function($join) {
                $join->on('b.category_id', '=', 'c.id');
            })
            ->join('tpublisher as f', function($join) {
                $join->on('b.publisher_id', '=', 'f.id');
            })
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
                        ) sr
                        group by sr.book_id, sr.user_id
                    )src
                    GROUP BY src.book_id) as d"), function($join) {
                $join->on('b.book_id', '=', 'd.book_id');
            });

            if ($user) {
                $query->selectRaw("CASE WHEN IFNULL(e.book_id, '') = '' THEN 'N' ELSE 'Y' END as rent")
                ->leftJoin('trent_book as e', function($join) use ($user) {
                    $join->on('b.book_id', '=', 'e.book_id')
                        ->where('e.flag_end', '=', 'N')
                        ->where('e.user_id', '=', $user->id);
                });
            }else{
                $query->selectRaw("'N' as rent");
            }

            // $results = $query->where('a.client_id', '=', $this->client_id)
            $results = $query->where('b.isbn', '=', $isbn)
            ->first();

        if ($results) {
            $results->image = (isset($results->image) && file_exists(public_path('/storage/covers/' . $results->image))) ? "/storage/covers/" . $results->image : '/storage/covers/default-cover.jpg';
        }

        // $queries = DB::getQueryLog();
        // for($q = 0; $q < count($queries); $q++) {
        //     $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
        //     $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
        //     $logs->write('SQL', $sql);
        // }
        // $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($results, 200);
    }

    public function getDetailAudioBook(Request $request)
    {
        $isbn = $request->id;
        $user = auth()->user();

        // $logs = new Logs( Arr::last(explode("\\", get_class())) );
        // $logs->write(__FUNCTION__, "START");
        // DB::enableQueryLog();

        $query = DB::table('tbook as b')
            ->select([
                'b.book_id',
                DB::raw('4 as copy'),
                'b.isbn',
                'b.title',
                'b.sinopsis',
                'b.cover as image',
                'b.writer',
                'b.age',
                'c.description as category',
                'b.year',
                'b.page',
                DB::raw("4 - IFNULL(d.total, 0) as remaining"),
				'f.description as publisher'
            ])
            ->join('tbook_category as c', function($join) {
                $join->on('b.category_id', '=', 'c.id');
            })
            ->join('tpublisher as f', function($join) {
                $join->on('b.publisher_id', '=', 'f.id');
            })
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
                        ) sr
                        group by sr.book_id, sr.user_id
                    )src
                    GROUP BY src.book_id) as d"), function($join) {
                $join->on('b.book_id', '=', 'd.book_id');
            });

            if ($user) {
                $query->selectRaw("CASE WHEN IFNULL(e.book_id, '') = '' THEN 'N' ELSE 'Y' END as rent")
                ->leftJoin('trent_book as e', function($join) use ($user) {
                    $join->on('b.book_id', '=', 'e.book_id')
                        ->where('e.flag_end', '=', 'N')
                        ->where('e.user_id', '=', $user->id);
                });
            }else{
                $query->selectRaw("'N' as rent");
            }

            // $results = $query->where('a.client_id', '=', $this->client_id)
            $results = $query->where('b.isbn', '=', $isbn)
            ->first();

        if ($results) {
            $results->image = (isset($results->image) && file_exists(public_path('/storage/covers/' . $results->image))) ? "/storage/covers/" . $results->image : '/storage/covers/default-cover.jpg';
        }

        // $queries = DB::getQueryLog();
        // for($q = 0; $q < count($queries); $q++) {
        //     $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
        //     $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
        //     $logs->write('SQL', $sql);
        // }
        // $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($results, 200);
    }

	private function getResult($client_id, $survey_id, $user_id){
		return DB::table('tquiz_trx as a')
			->select(
				DB::raw("SUM(a.point) as nilai"),
				DB::raw("COUNT(a.question_id) as finished")
			)
			->where('a.client_id', '=', $client_id)
			->where('a.survey_id', '=', $survey_id)
			->where('a.user_id', '=', $user_id)
			->first();
	}
}
