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
    public function get($filter, $client_id): Collection
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
			->where('a.client_id', '=', $client_id)
			->get();
    }

	/**
     * @param object $data
     * @return bool
     */
    public function store(object $data, $client_id): bool
    {
        return DB::transaction(function () use ($data, $client_id) {
            return DB::table('tbanner')->insert([
                'id' => $data->id,
				'description' => $data->desc,
				'file' => $data->file,
				'disp_type' => $data->type,
				'client_id' => $client_id,
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
    public function update(object $data, string $id, $client_id): bool
    {
        return DB::transaction(function () use ($data, $id, $client_id) {
            return DB::table('tbanner')->where('id', $id)->where('client_id', $client_id)
                ->update([
                    'description' => $data->desc,
                    'file' => $data->file,
                    'disp_type' => $data->type,
                    'updated_at' => $data->modified_date,
                    'updated_by' => $data->modified_by
                ]);
        });
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function delete(string $id, $client_id)
    {
        return DB::transaction(function () use ($id, $client_id) {
            $banner = DB::table('tbanner')
                ->where('client_id', $client_id)
                ->where('id', $id);

            $banner_file = $banner->first();
            @unlink(storage_path('app/public/banner/'.$banner_file->file));

            return $banner->delete();
        });
    }
}