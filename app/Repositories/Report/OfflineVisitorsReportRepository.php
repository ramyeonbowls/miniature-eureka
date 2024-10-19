<?php

namespace App\Repositories\Report;

use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class OfflineVisitorsReportRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get($filter): Collection
    {
        $client_id = $this->getClientID($filter);
        extract($filter);

        return DB::table('tvisitors_offline as a')
            ->select(
                'b.instansi_name as wl_name',
                'b.provinsi_id',
                'c.provinsi_name',
                'b.kabupaten_id',
                'd.kabupaten_name',
                DB::raw("COUNT(a.id) as visitor")
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
            ->where('a.client_id', '=', $client_id)
            ->where('b.provinsi_id', '=', $PROVINSI)
            ->where('b.kabupaten_id', '=', $KABUPATEN)
            ->when(!empty($END_DATE), function ($query) use ($START_DATE, $END_DATE) {
                return $query->whereBetween('a.date', [$START_DATE, $END_DATE]);
            }, function ($query) use ($START_DATE) {
                return $query->where('a.date', '=', $START_DATE);
            })
            ->groupBy('b.instansi_name', 'b.provinsi_id', 'c.provinsi_name', 'b.kabupaten_id', 'd.kabupaten_name')
            ->sharedLock()
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