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
	
	/**
     * @param object $data
     * @param string $id
     * @return bool
     */
    public function update(object $data, string $id): bool
    {
        return DB::transaction(function () use ($data, $id) {
            return DB::table('tbanner')->where('id', $id)
                ->update([
                    'description' => $data->desc,
                    'file' => $data->file,
                    'disp_type' => $data->type,
                    'client_id' => '',
                    'updated_at' => $data->modified_date,
                    'updated_by' => $data->modified_by
                ]);
        });
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function delete(string $id)
    {
        return DB::transaction(function () use ($id) {
            $banner = DB::table('tbanner')
                ->where('id', $id);

            $banner_file = $banner->first();
            @unlink(storage_path('app/public/banner/'.$banner_file->file));

            return $banner->delete();
        });
    }
}