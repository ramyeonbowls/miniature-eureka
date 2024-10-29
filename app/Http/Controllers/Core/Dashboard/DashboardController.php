<?php

namespace App\Http\Controllers\Core\Dashboard;

use App\Logs;
use App\Libraries;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $client_id	= '';
    public function __construct()
    {
        $this->middleware('auth');
        $this->client_id	= config('app.client_id', '');
		$this->isDinas		= Libraries::isDinas();
    }

    public function dashAtas()
    {
		$logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, "START");
        DB::enableQueryLog();

		if($this->isDinas['status']){
			$client_id	= $this->getClientID($this->client_id, $this->isDinas);
		}else{
			$client_id	= [$this->client_id];
		}

        $visitor = DB::table('tvisitors as a')
            ->select([
                DB::raw('COUNT(a.id) as visitor')
            ])
            ->whereIn('a.client_id', $client_id)
			->first();

		$book = DB::table('tmapping_book as a')
            ->select([
                DB::raw('COUNT(a.book_id) as book')
            ])
            ->whereIn('a.client_id', $client_id)
			->first();

		$member = DB::table('users as a')
            ->select([
                DB::raw('COUNT(a.id) as member')
            ])
            ->whereIn('a.client_id', $client_id)
			->first();

		$po = 0;

		$results = [
			'visitor'	=> number_format($visitor->visitor, 0, ',', '.'),
			'book'		=> number_format($book->book, 0, ',', '.'),
			'member'	=> number_format($member->member, 0, ',', '.'),
			'po'		=> number_format($po, 0, ',', '.')
		];

		$queries = DB::getQueryLog();
        for($q = 0; $q < count($queries); $q++) {
            $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
            $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
            $logs->write('SQL', $sql);
        }

        $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($results, 200);
    }

	private function getClientID($client_id, $isDinas)
	{
		$sql = DB::table('tclient as a')
			->select(
				'a.client_id'
			);

		if($this->isDinas['level'] != '6001'){
			$sql->where('a.provinsi_id', $this->isDinas['provinsi']);
		}

		if($this->isDinas['level'] == '6003'){
			$sql->where('a.kabupaten_id', $this->isDinas['kabupaten']);
		}

		$results = $sql->get()->pluck('client_id');

		return $results;
	}
}
