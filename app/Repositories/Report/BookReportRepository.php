<?php

namespace App\Repositories\Report;

use App\Libraries;
use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BookReportRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get($filter): Collection
    {
        $client_id = $this->getClientID($filter) ?? [];
        extract($filter);

        return DB::table('tmapping_book as a')
			->select(
				'a.book_id',
				'b.cover',
				'b.title',
				'b.isbn',
				'b.eisbn',
				'b.year',
				'b.writer',
				'd.description as publisher',
				'c.description as category',
                'a.copy as qty',
                'e.provinsi_id',
                'f.provinsi_name',
                'e.kabupaten_id',
                'g.kabupaten_name',
                'e.instansi_name as wl_name'
			)
            ->join('tbook as b', function($join) {
                $join->on('a.book_id', '=', 'b.book_id');
            })
            ->join('tbook_category as c', function($join) {
                $join->on('b.category_id', '=', 'c.id');
            })
            ->leftjoin('tpublisher as d', function($join) {
                $join->on('b.publisher_id', '=', 'd.id');
            })
            ->join('tclient as e', function ($join) {
                $join->on('a.client_id', '=', 'e.client_id');
            })
            ->join('tprovinsi as f', function ($join) {
                $join->on('e.provinsi_id', '=', 'f.provinsi_id');
            })
            ->join('tkabupaten as g', function ($join) {
                $join->on('e.kabupaten_id', '=', 'g.kabupaten_id');
            })
            ->whereIn('a.client_id', $client_id)
            ->where('e.provinsi_id', '=', $PROVINSI)
            ->where('e.kabupaten_id', '=', $KABUPATEN)
			->orderBy('e.instansi_name', 'ASC')
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