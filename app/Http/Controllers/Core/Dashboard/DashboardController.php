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
			->where('a.role', 'member')
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

    public function dashBawah(Request $request)
    {
		$logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, "START");
        DB::enableQueryLog();

		if($this->isDinas['status']){
			$client_id	= $this->getClientID($this->client_id, $this->isDinas);
		}else{
			$client_id	= [$this->client_id];
		}

		$days			= $this->getDates($request->date);
		$months			= $this->getMonths($request->date);
		$formattedDate	= Carbon::createFromFormat('Y-m', $request->date)->format('F Y');

		$read_daily		= $this->ReadDaily($request, $days, $client_id);
		$visit_daily	= $this->VisitDaily($request, $days, $client_id);
		$read_monthly	= $this->ReadMonthly($request, $months, $client_id);
		$visit_monthly	= $this->VisitMonthly($request, $months, $client_id);
		$growth_member	= $this->GrowthMember($request, $months, $client_id);
		$member_read	= $this->TopMemberRead($request, $client_id);
		$book_read		= $this->TopBookRead($request, $client_id);

		$results = [
			'days'			=> $days,
			'months'		=> $months['name'],
			'formattedDate'	=> $formattedDate,
			'read_daily'	=> $read_daily,
			'visit_daily'	=> $visit_daily,
			'read_monthly'	=> $read_monthly,
			'visit_monthly'	=> $visit_monthly,
			'growth_member'	=> $growth_member,
			'member_read'	=> $member_read,
			'book_read'		=> $book_read,
		];

		$queries = DB::getQueryLog();
        for($q = 0; $q < count($queries); $q++) {
            $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
            $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
            $logs->write('SQL', $sql."\r\n");
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

	private function getDates($date) {
		$dateArray = [];

		$startDate = Carbon::parse($date)->startOfMonth();
		$endDate = Carbon::parse($date)->endOfMonth();
		$currentDate = Carbon::now();

		if ($startDate->isSameMonth($currentDate)) {
			$endDate = $currentDate;
		}

		while ($startDate->lte($endDate)) {
			$dateArray[] = $startDate->format('d');
			$startDate->addDay();
		}

		return $dateArray;
	}
	
	private function getMonths($date) {
		$monthArray = [];

		$date = Carbon::parse($date);
		$year = $date->year;
		$months = Carbon::create($year, 1, 1)->months();
		$monthNumbers = range(1, 12);
		$monthNames = [];

		foreach ($monthNumbers as $month) {
			$monthArray['name'][]	= Carbon::createFromFormat('Y-m', "$year-$month")->format('M');
			$monthArray['month'][]	= Carbon::createFromFormat('Y-m', "$year-$month")->format('Y-m');
		}

		return $monthArray;
	}

	private function ReadDaily($request, $days, $client_id) {
		$reader = DB::table('ttrx_read as a')
            ->select([
                DB::raw('DAY(start_read) as day'),
                DB::raw('COUNT(DISTINCT a.book_id) as reader')
				
            ])
			->join('tclient as b', function($join) {
				$join->on('a.client_id', '=', 'b.client_id');
			})
            ->whereRaw("DATE_FORMAT(a.start_read, '%Y-%m') = '$request->date'")
            ->whereIn('a.client_id', $client_id)
			->when($request->provinsi != '', function($query) use ($request) {
				$query->where('b.provinsi_id', $request->provinsi);
			})
			->when($request->kabupaten != '', function($query) use ($request) {
				$query->where('b.kabupaten_id', $request->kabupaten);
			})
			->when($request->wl != '', function($query) use ($request) {
				$query->where('b.instansi_name', $request->wl);
			})
			->groupBy(DB::raw('DAY(start_read)'))
			->get();

		$result = collect($days)->map(function($day) use ($reader) {
			$existingDay = $reader->firstWhere('day', $day);
			return [
				'day' => $day,
				'data' => $existingDay ? $existingDay->reader : 0
			];
		});

		return $result;
	}

	private function VisitDaily($request, $days, $client_id) {
		$visitor = DB::table('tvisitors as a')
            ->select([
                DB::raw('DAY(date) as day'),
                DB::raw('COUNT(DISTINCT a.id) as visitor')
				
            ])
			->join('tclient as b', function($join) {
				$join->on('a.client_id', '=', 'b.client_id');
			})
            ->whereRaw("DATE_FORMAT(a.date, '%Y-%m') = '$request->date'")
            ->whereIn('a.client_id', $client_id)
			->when($request->provinsi != '', function($query) use ($request) {
				$query->where('b.provinsi_id', $request->provinsi);
			})
			->when($request->kabupaten != '', function($query) use ($request) {
				$query->where('b.kabupaten_id', $request->kabupaten);
			})
			->when($request->wl != '', function($query) use ($request) {
				$query->where('b.instansi_name', $request->wl);
			})
			->groupBy(DB::raw('DAY(date)'))
			->get();

		$result = collect($days)->map(function($day) use ($visitor) {
			$existingDay = $visitor->firstWhere('day', $day);
			return [
				'day' => $day,
				'data' => $existingDay ? $existingDay->visitor : 0
			];
		});

		return $result;
	}

	private function ReadMonthly($request, $months, $client_id) {
		$month = implode("', '", $months['month']);
		$reader = DB::table('ttrx_read as a')
            ->select([
                DB::raw("DATE_FORMAT(a.start_read, '%Y-%m') as month"),
                DB::raw('COUNT(DISTINCT a.book_id) as reader')
				
            ])
			->join('tclient as b', function($join) {
				$join->on('a.client_id', '=', 'b.client_id');
			})
            ->whereRaw("DATE_FORMAT(a.start_read, '%Y-%m') IN ('$month')")
            ->whereIn('a.client_id', $client_id)
			->when($request->provinsi != '', function($query) use ($request) {
				$query->where('b.provinsi_id', $request->provinsi);
			})
			->when($request->kabupaten != '', function($query) use ($request) {
				$query->where('b.kabupaten_id', $request->kabupaten);
			})
			->when($request->wl != '', function($query) use ($request) {
				$query->where('b.instansi_name', $request->wl);
			})
			->groupBy(DB::raw("DATE_FORMAT(start_read, '%Y-%m')"))
			->get();

		$result = collect($months['month'])->map(function($month) use ($reader) {
			$existingMonth = $reader->firstWhere('month', $month);
			return [
				'month' => $month,
				'data' => $existingMonth ? $existingMonth->reader : 0
			];
		});

		return $result;
	}

	private function VisitMonthly($request, $months, $client_id) {
		$month = implode("', '", $months['month']);
		$visitor = DB::table('tvisitors as a')
            ->select([
                DB::raw("DATE_FORMAT(a.date, '%Y-%m') as month"),
                DB::raw('COUNT(DISTINCT a.id) as visitor')
				
            ])
			->join('tclient as b', function($join) {
				$join->on('a.client_id', '=', 'b.client_id');
			})
            ->whereRaw("DATE_FORMAT(a.date, '%Y-%m') IN ('$month')")
            ->whereIn('a.client_id', $client_id)
			->when($request->provinsi != '', function($query) use ($request) {
				$query->where('b.provinsi_id', $request->provinsi);
			})
			->when($request->kabupaten != '', function($query) use ($request) {
				$query->where('b.kabupaten_id', $request->kabupaten);
			})
			->when($request->wl != '', function($query) use ($request) {
				$query->where('b.instansi_name', $request->wl);
			})
			->groupBy(DB::raw("DATE_FORMAT(date, '%Y-%m')"))
			->get();

		$result = collect($months['month'])->map(function($month) use ($visitor) {
			$existingMonth = $visitor->firstWhere('month', $month);
			return [
				'month' => $month,
				'data' => $existingMonth ? $existingMonth->visitor : 0
			];
		});

		return $result;
	}

	private function GrowthMember($request, $months, $client_id) {
		$month = implode("', '", $months['month']);
		$visitor = DB::table('users as a')
            ->select([
                DB::raw("DATE_FORMAT(a.created_at, '%Y-%m') as month"),
                DB::raw('COUNT(DISTINCT a.id) as visitor')
				
            ])
			->join('tclient as b', function($join) {
				$join->on('a.client_id', '=', 'b.client_id');
			})
            ->whereRaw("DATE_FORMAT(a.created_at, '%Y-%m') IN ('$month')")
            ->whereIn('a.client_id', $client_id)
			->when($request->provinsi != '', function($query) use ($request) {
				$query->where('b.provinsi_id', $request->provinsi);
			})
			->when($request->kabupaten != '', function($query) use ($request) {
				$query->where('b.kabupaten_id', $request->kabupaten);
			})
			->when($request->wl != '', function($query) use ($request) {
				$query->where('b.instansi_name', $request->wl);
			})
			->groupBy(DB::raw("DATE_FORMAT(a.created_at, '%Y-%m')"))
			->get();

		$result = collect($months['month'])->map(function($month) use ($visitor) {
			$existingMonth = $visitor->firstWhere('month', $month);
			return [
				'month' => $month,
				'data' => $existingMonth ? $existingMonth->visitor : 0
			];
		});

		return $result;
	}

	private function TopMemberRead($request, $client_id) {
		$member = DB::table('ttrx_read as a')
            ->select([
				'a.user_id',
				'c.name',
                DB::raw('SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, start_read, end_read))) as totalJam')
				
            ])
			->join('tclient as b', function($join) {
				$join->on('a.client_id', '=', 'b.client_id');
			})
			->join('users as c', function($join) {
				$join->on('a.user_id', '=', 'c.id');
			})
            ->whereRaw("DATE_FORMAT(a.created_at, '%Y-%m') = '$request->date'")
            ->whereIn('a.client_id', $client_id)
			->when($request->provinsi != '', function($query) use ($request) {
				$query->where('b.provinsi_id', $request->provinsi);
			})
			->when($request->kabupaten != '', function($query) use ($request) {
				$query->where('b.kabupaten_id', $request->kabupaten);
			})
			->when($request->wl != '', function($query) use ($request) {
				$query->where('b.instansi_name', $request->wl);
			})
			->groupBy('a.user_id', 'c.name')
			->orderByRaw('SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, start_read, end_read))) DESC')
			->limit(10)
			->get();

		return $member;
	}

	private function TopBookRead($request, $client_id) {
		$book = DB::table('ttrx_read as a')
            ->select([
				'a.book_id',
				'c.title',
				'c.cover',
                DB::raw('COUNT(DISTINCT a.user_id) as totalRead')
				
            ])
			->join('tclient as b', function($join) {
				$join->on('a.client_id', '=', 'b.client_id');
			})
			->join('tbook as c', function($join) {
				$join->on('a.book_id', '=', 'c.book_id');
			})
            ->whereRaw("DATE_FORMAT(a.start_read, '%Y-%m') = '$request->date'")
            ->whereIn('a.client_id', $client_id)
			->when($request->provinsi != '', function($query) use ($request) {
				$query->where('b.provinsi_id', $request->provinsi);
			})
			->when($request->kabupaten != '', function($query) use ($request) {
				$query->where('b.kabupaten_id', $request->kabupaten);
			})
			->when($request->wl != '', function($query) use ($request) {
				$query->where('b.instansi_name', $request->wl);
			})
			->groupBy('a.book_id', 'c.title', 'c.cover')
			->orderByRaw('COUNT(DISTINCT a.user_id) DESC')
			->limit(10)
			->get()
			->map(function ($value) {
                return [
                    'book_id'	=> $value->book_id,
                    'title'		=> $value->title,
                    'totalRead'	=> $value->totalRead,
                    'cover'		=> (isset($value->cover) && file_exists(public_path('/storage/covers/' . $value->cover))) 
                                    ? '/storage/covers/' . $value->cover
                                    : '/storage/covers/default-cover.jpg'
                ];
            });

		return $book;
	}

	public function getKatalog(Request $request)
    {
        // $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        // $logs->write(__FUNCTION__, "START");
        // DB::enableQueryLog();

        $results = DB::table('tbook as a')
            ->select([
                'a.book_id',
                'a.title',
                'a.cover as image',
                'a.writer'
            ])
			->orderBy('createdate', 'DESC')
			->limit(10)
            ->get()
            ->map(function ($value) {
                return [
                    'title'    => $value->title,
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
}
