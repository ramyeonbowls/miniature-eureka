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
    
    public function getBook(Request $request)
    {
        $logs = new Logs( Arr::last(explode("\\", get_class())) );
        $logs->write(__FUNCTION__, "START");
        DB::enableQueryLog();

        $results    = [];
        $category   = $request->categories ?? [];
        $parameter  = $request->search ?? '';

        $sql = DB::table('tbook as a')
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
                    ->orWhere('a.title', 'LIKE', '%' . $parameter . '%');
			})
            ->when(count($category)>0, function($query) use ($category) {
				$query->whereIn('a.category_id', $category);
			})
            ->get();

        foreach ($sql as $i => $value) {
            $results[$i]['isbn']        = $value->isbn;
            $results[$i]['title']       = $value->title;
            $results[$i]['sinopsis']    = $value->sinopsis;
            $results[$i]['filename']    = $value->filename;
            $results[$i]['image']       = ( isset($value->image) && file_exists(public_path('/images/cover/'. $value->image)) ) ? "/images/cover/".$value->image : '/images/cover/default-cover.jpg';
            $results[$i]['writer']      = $value->writer;
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
        $results = [];

        $sql = DB::table('tbook_category as a')
            ->select([
                'a.id',
                'a.description'
            ])
            ->get();

        foreach ($sql as $i => $value) {
            $results[$i]['id']          = $value->id;
            $results[$i]['description'] = $value->description;
        }

        return response()->json($results, 200);
    }
}
