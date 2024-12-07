<?php

namespace App\Repositories\Report;

use App\Libraries;
use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MemberReportRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get($filter): Collection
    {
        $client_id = $this->getClientID($filter) ?? [];
        extract($filter);

        return DB::table('tclient as a')
            ->select(
                'a.instansi_name as wl_name',
                'a.provinsi_id',
                'c.provinsi_name',
                'a.kabupaten_id',
                'd.kabupaten_name',
                'b.name',
                'b.email',
                'b.created_at'
            )
            ->join('users as b', function ($join) {
                $join->on('a.client_id', '=', 'b.client_id');
            })
            ->join('tprovinsi as c', function ($join) {
                $join->on('a.provinsi_id', '=', 'c.provinsi_id');
            })
            ->join('tkabupaten as d', function ($join) {
                $join->on('a.kabupaten_id', '=', 'd.kabupaten_id');
            })
            ->whereIn('a.client_id', $client_id)
            ->where('a.provinsi_id', '=', $PROVINSI)
            ->where('a.kabupaten_id', '=', $KABUPATEN)
			->where('b.role', '=', 'member')
			->orderBy('a.instansi_name', 'ASC')
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