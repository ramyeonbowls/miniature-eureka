<?php

namespace App\Repositories\Report;

use App\Libraries;
use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LibraryOfficerReportRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get($filter): Collection
    {
        $client_id = $this->getClientID($filter) ?? [];
        extract($filter);

        return DB::table('tlibrary_officers as a')
            ->select(
                'b.instansi_name as wl_name',
                'b.provinsi_id',
                'c.provinsi_name',
                'b.kabupaten_id',
                'd.kabupaten_name',
                'a.nip',
                'a.name',
                'a.position'
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
            ->whereIn('a.client_id', $client_id)
            ->where('b.provinsi_id', '=', $PROVINSI)
            ->where('b.kabupaten_id', '=', $KABUPATEN)
			->orderBy('b.instansi_name', 'ASC')
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