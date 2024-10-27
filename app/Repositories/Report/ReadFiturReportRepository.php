<?php

namespace App\Repositories\Report;

use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class ReadFiturReportRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get($filter): Collection
    {
        $client_id = $this->getClientID($filter);
        extract($filter);

        return DB::table('tread_fitur as a')
            ->select(
                'b.instansi_name as wl_name',
                'b.provinsi_id',
                'c.provinsi_name',
                'b.kabupaten_id',
                'd.kabupaten_name',
                'e.title',
                DB::raw("CASE
					WHEN e.category = 'FR' THEN 'Frasa'
					WHEN e.category = 'HU' THEN 'Humoria'
					WHEN e.category = 'LP' THEN 'Layar Penulis'
					WHEN e.category = 'RB' THEN 'Review Buku'
					WHEN e.category = 'TF' THEN 'Titik Fokus'
					WHEN e.category = 'TU' THEN 'Tajuk Utama'
					WHEN e.category = 'WA' THEN 'Wawasan'
					ELSE ''
				END as fitur"),
                DB::raw("COUNT(a.id) as reader")
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
            ->join('tfitur as e', function ($join) {
                $join->on('a.client_id', '=', 'e.client_id')
                	->on('a.fitur', '=', 'e.category')
                	->on('a.id_fitur', '=', 'e.id');
            })
            ->where('a.client_id', '=', $client_id)
            ->where('b.provinsi_id', '=', $PROVINSI)
            ->where('b.kabupaten_id', '=', $KABUPATEN)
            ->when(!empty($END_DATE), function ($query) use ($START_DATE, $END_DATE) {
                return $query->whereBetween(DB::raw("CONVERT(a.created_at, DATE)"), [$START_DATE, $END_DATE]);
            }, function ($query) use ($START_DATE) {
                return $query->where(DB::raw("CONVERT(a.created_at, DATE)"), '=', $START_DATE);
            })
            ->groupBy('b.instansi_name', 'b.provinsi_id', 'c.provinsi_name', 'b.kabupaten_id', 'd.kabupaten_name', 'e.title', 'e.category')
            ->get();
    }
    
    private function getClientID($filter)
    {
        extract($filter);

        $query = DB::table('tclient as a')
            ->select(
                'a.client_id'
            )
            ->where('a.provinsi_id', '=', $PROVINSI)
            ->where('a.kabupaten_id', '=', $KABUPATEN)
            ->where('a.instansi_name', '=', $WL)
            ->sharedLock()
            ->get();
        return $query[0]->client_id ?? '';
    }
}