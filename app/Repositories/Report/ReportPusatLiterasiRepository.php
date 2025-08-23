<?php

namespace App\Repositories\Report;

use App\Libraries;
use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReportPusatLiterasiRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get($filter): Collection
    {
        return DB::table('login_by_qr as a')
            ->select(
                'a.uuid as sesId',
                DB::raw("CONCAT(SUBSTRING_INDEX(SUBSTRING_INDEX(a.device, '|', 1), '|', -1), ' ', SUBSTRING_INDEX(SUBSTRING_INDEX(a.device, '|', 2), '|', -1)) as device"),
                DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(a.device, '|', 3), '|', -1) as systemOs"),
                DB::raw("SUBSTRING_INDEX(SUBSTRING_INDEX(a.device, '|', 4), '|', -1) as browser"),
                DB::raw("SUBSTRING_INDEX(a.device, '|', -1) as ip_address"),
                'a.created_at as visit',
                'c.title as judulBuku',
                'b.start_read as mulaiBaca',
                'b.end_read as selesaiBaca',
                DB::raw('0 as presentaseBaca'),
                DB::raw('SEC_TO_TIME(SUM(CASE WHEN b.end_read > b.start_read THEN TIMESTAMPDIFF(SECOND, b.start_read, b.end_read) ELSE TIMESTAMPDIFF(SECOND, b.end_read, b.start_read) END)) as durationRead')
            )
            ->leftJoin('ttrx_read as b', function ($join) {
                $join->on('a.client_id', '=', 'b.client_id')
                ->on('a.uuid', '=', 'b.id');
            })
            ->leftJoin('tbook as c', function ($join) {
                $join->on('b.book_id', '=', 'c.book_id');
            })
            ->where('a.client_id', $filter['client_id'])
            ->where('b.flag_end', '=', 'Y')
            ->when(!empty($filter['end_date']), function ($query) use ($filter) {
                return $query->whereBetween(DB::raw('DATE(a.created_at)'), [$filter['start_date'], $filter['end_date']]);
            }, function ($query) use ($filter) {
                return $query->where(DB::raw('DATE(a.created_at)'), '=', $filter['start_date']);
            })
            ->groupBy('a.uuid')
            ->get();
    }
}