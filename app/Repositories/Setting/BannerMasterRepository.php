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
				'a.created_at',
				'a.created_by',
				'a.updated_at',
				'a.updated_by',
			)
			->sharedLock()
			->get();
    }

	/**
     * @param object $data
     * @return bool
     */
    public function store(object $data): bool
    {
        return DB::transaction(function () use ($data) {
            return DB::table('tbanner')->insert([
                'id' => $data->id,
				'description' => $data->desc,
				'file' => $data->file,
				'disp_type' => $data->type,
				'client_id' => '',
				'created_at' => $data->create_date,
				'created_by' => $data->create_by,
				'updated_at' => $data->modified_date,
				'updated_by' => $data->modified_by,
            ]);
        });
    }
}