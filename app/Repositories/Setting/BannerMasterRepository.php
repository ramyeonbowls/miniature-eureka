<?php

namespace App\Repositories\Setting;

use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class BannerMasterRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get(): Collection
    {
        return DB::table('tbanner as a')
			->select(
				'a.id',
				'a.description',
				'a.file',
				'a.disp_type',
				'a.client_id',
				'a.created_at',
				'a.created_by',
				'a.updated_at',
				'a.updated_by',
			)
			->sharedLock()
			->get();
    }
}