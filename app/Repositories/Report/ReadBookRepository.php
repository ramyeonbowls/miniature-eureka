<?php

namespace App\Repositories\Report;

use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class ReadBookRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get($filter, $client_id): Collection
    {
        extract($filter);

        return DB::table('ttrx_read as a')
            ->select(
                'b.provinsi_id',
                'c.provinsi_name',
                'b.kabupaten_id',
                'd.kabupaten_name',
                DB::raw('COUNT(DISTINCT a.user_id) AS pembaca'),
                DB::raw('SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, a.start_read, a.end_read))) AS durasi'),
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
            ->where('a.client_id', '=', $client_id)
            ->where('b.provinsi_id', '=', $PROVINSI)
            ->where('b.kabupaten_id', '=', $KABUPATEN)
            ->when(!empty($END_DATE), function ($query) use ($START_DATE, $END_DATE) {
                return $query->whereBetween(DB::raw('DATE(a.created_at)'), [$START_DATE, $END_DATE]);
            }, function ($query) use ($START_DATE) {
                return $query->where(DB::raw('DATE(a.created_at)'), '=', $START_DATE);
            })
            ->groupBy('b.provinsi_id', 'c.provinsi_name', 'b.kabupaten_id', 'd.kabupaten_name', 'b.instansi_name')
            ->sharedLock()
            ->get();
    }
}