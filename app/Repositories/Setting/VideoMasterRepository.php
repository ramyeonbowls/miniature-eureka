<?php

namespace App\Repositories\Setting;

use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class VideoMasterRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get($filter, $client_id): Collection
    {
        return DB::table('tvideo as a')
			->select(
				'a.id',
				'a.title',
				'a.description',
				'a.file',
				'a.flag_aktif',
				'a.flag_platform',
				'a.client_id',
				'a.created_at',
				'a.created_by',
				'a.updated_at',
				'a.update_by',
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
            return DB::table('tvideo')->insert([
                'id'            => $data->id,
				'title'         => $data->title,
				'description'   => $data->description,
				'file'          => $data->file,
				'flag_aktif'    => $data->flag_aktif,
				'flag_platform' => 'N',
				'client_id'     => $client_id,
				'created_at'    => $data->create_date,
				'created_by'    => $data->create_by
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
            return DB::table('tvideo')->where('id', $id)->where('client_id', '=', $client_id)
                ->update([
                    'title'         => $data->title,
                    'description'   => $data->description,
                    'file'          => $data->file,
                    'flag_aktif'    => $data->flag_aktif,
                    'flag_platform' => 'N',
                    'updated_at'    => $data->modified_date,
                    'update_by'     => $data->modified_by
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
            $Video = DB::table('tvideo')
                ->where('client_id', '=', $client_id)
                ->where('id', $id);

            return $Video->delete();
        });
    }
}