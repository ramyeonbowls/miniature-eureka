<?php

namespace App\Http\Controllers;

use App\Logs;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Web\WebMenuService;

class HomeController extends Controller
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
    public function index()
    {
        return view('home');
    }

    /**
     * Show forbidden page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function forbidden()
    {
        if(auth()->user()->activated) {
            return redirect(\App\Providers\RouteServiceProvider::HOME);
        }

        return view('errors.403');
    }

    public function userInfo()
    {
        $user = auth()->user();

		$appname = '';
		if($user){
			$results = DB::table('tclient as a')
				->select([
					'a.application_name',
				])
				->where('a.client_id', '=' , $this->client_id)
				->first();
			
			$appname = $results->application_name;
		}

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'appname' => $appname
        ], 200);
    }

    public function webMenuAcl()
    {
        $logs = new Logs( auth()->user()->email .'_'. Arr::last(explode("\\", get_class())) );
        $logs->write(__FUNCTION__, "START");

        $my_webmenus = [];
        try {
            $webMenuService = new WebMenuService(new \App\Repositories\Web\WebMenuRepository());
            $my_webmenus = $webMenuService->getAccessControlList(auth()->user()->email);
        } catch (\Throwable $th) {
            $logs->write("ERROR", $th->getMessage());
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($my_webmenus, 200);
    }

    public function main()
    {
        return view('main');
    }
}
