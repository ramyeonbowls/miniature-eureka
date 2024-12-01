<?php

namespace App\Repositories\Report;

use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class POReportRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get($filter): Collection
    {
        $client_id = $this->getClientID($filter);
        extract($filter);

        return DB::table('db_platform_ginesia.tpo_header as a')
            ->select(
                'b.instansi_name as wl_name',
                'b.provinsi_id',
                'c.provinsi_name',
                'b.kabupaten_id',
                'd.kabupaten_name',
                'a.po_number',
                DB::raw("CASE WHEN a.po_type = '1' THEN 'Penjualan' WHEN a.po_type = '2' THEN 'Hibah' ELSE '' END as po_type "),
                'a.po_date',
                'a.po_amount'
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
                return $query->whereBetween('a.po_date', [$START_DATE, $END_DATE]);
            }, function ($query) use ($START_DATE) {
                return $query->where('a.po_date', '=', $START_DATE);
            })
            ->get();
    }

	/**
     * @param array $filter
     * @return Collection
     */
    public function getDetail($filter): Collection
    {
        extract($filter);

        return DB::table('db_platform_ginesia.tpo_detail as a')
            ->select(
                'a.po_number',
                'a.po_date',
                'a.sellprice',
                'a.qty',
                'b.cover',
                'b.title',
                'b.writer',
                'd.description as publisher'
            )
            ->join('tbook as b', function ($join) {
                $join->on('a.book_id', '=', 'b.book_id');
            })
			->leftjoin('tpublisher as d', function($join) {
                $join->on('b.publisher_id', '=', 'd.id');
            })
            ->where('a.po_number', '=', $PO_NUMBER)
            ->where('a.po_date', '=', $PO_DATE)
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