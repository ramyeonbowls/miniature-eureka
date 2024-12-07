<?php

namespace App\Repositories\Report;

use App\Libraries;
use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReadBookUserRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get($filter): Collection
    {
        $client_id = $this->getClientID($filter) ?? [];
        extract($filter);

        return DB::table('ttrx_read as a')
            ->select(
                'b.provinsi_id',
                'c.provinsi_name',
                'b.kabupaten_id',
                'd.kabupaten_name',
                'e.name',
                DB::raw('COUNT(DISTINCT a.book_id) AS dibaca'),
                DB::raw('SEC_TO_TIME(SUM(
						CASE
							WHEN a.end_read > a.start_read THEN TIMESTAMPDIFF(SECOND, a.start_read, a.end_read)
							ELSE TIMESTAMPDIFF(SECOND, a.end_read, a.start_read)
						END
					)) AS durasi
				'),
                DB::raw("CONCAT(
                    FLOOR(SUM(TIMESTAMPDIFF(SECOND, a.start_read, a.end_read)) / 3600), ' jam ',
                    FLOOR((SUM(TIMESTAMPDIFF(SECOND, a.start_read, a.end_read)) % 3600) / 60), ' menit ',
                    (SUM(TIMESTAMPDIFF(SECOND, a.start_read, a.end_read)) % 60), ' detik'
                ) AS jam"),
                'b.instansi_name as wl_name'
            )
            ->join('tclient as b', function ($join) {
                $join->on('a.client_id', '=', 'b.client_id');
            })
            ->join('tprovinsi as c', function ($join) {
                $join->on('b.provinsi_id', '=', 'c.provinsi_id');
            })
            ->join('tkabupaten as d', function ($join) {
                $join->on('b.kabupaten_id', '=', 'd.kabupaten_id');
            })
            ->join('users as e', function ($join) {
                $join->on('a.user_id', '=', 'e.id')
                    ->on('a.client_id', '=', 'e.client_id');
            })
            ->whereIn('a.client_id', $client_id)
            ->where('b.provinsi_id', '=', $PROVINSI)
            ->where('b.kabupaten_id', '=', $KABUPATEN)
            ->where('a.flag_end', '=', 'Y')
            ->when(!empty($END_DATE), function ($query) use ($START_DATE, $END_DATE) {
                return $query->whereBetween(DB::raw('DATE(a.created_at)'), [$START_DATE, $END_DATE]);
            }, function ($query) use ($START_DATE) {
                return $query->where(DB::raw('DATE(a.created_at)'), '=', $START_DATE);
            })
            ->groupBy('b.provinsi_id', 'c.provinsi_name', 'b.kabupaten_id', 'd.kabupaten_name', 'e.name', 'b.instansi_name')
            ->sharedLock()
            ->get();
    }
    
    private function getClientID($filter)
    {
        extract($filter);

		if($WL!=''){
			$query = DB::table('tclient as a')
				->select(
					'a.client_id'
				)
				->where('a.provinsi_id', '=', $PROVINSI)
				->where('a.kabupaten_id', '=', $KABUPATEN)
				->where('a.instansi_name', '=', $WL)
				->get()
				->pluck('client_id');
		}else{
			$isDinas		= Libraries::isDinas();

			$sql = DB::table('tclient as a')
				->select(
					'a.client_id'
				);

			if($isDinas['level'] != '6001'){
				$sql->where('a.provinsi_id', $isDinas['provinsi']);
			}

			if($isDinas['level'] == '6003'){
				$sql->where('a.kabupaten_id', $isDinas['kabupaten']);
			}

			$query = $sql->get()->pluck('client_id');
		}
        return $query;
    }
}