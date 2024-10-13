<?php

namespace App\Repositories\Master;

use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class BookMasterRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get($client_id): Collection
    {
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
                'a.copy as qty'
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
            ->where('a.client_id', '=', $client_id)
			->sharedLock()
			->get();
    }
}