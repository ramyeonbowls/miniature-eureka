<?php

namespace App\Repositories\Master;

use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class LibraryOfficerMasterRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get($client_id): Collection
    {
        return DB::table('tlibrary_officers as a')
			->select(
				'a.id',
				'a.nip',
				'a.name',
				'a.position'
			)
            ->where('a.client_id', '=', $client_id)
			->sharedLock()
			->get();
    }

	/**
     * @param object $data
     * @return bool
     */
    public function store(object $data, $client_id): bool
    {
        return DB::transaction(function () use ($data, $client_id) {
            return DB::table('tlibrary_officers')->insert([
				'client_id'		=> $client_id,
                'nip'			=> $data->nip,
				'name'			=> $data->name,
				'position'		=> $data->position,
				'created_by'	=> $data->created_by,
				'created_at'	=> $data->created_at
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
            return DB::table('tlibrary_officers')->where('id', $id)->where('client_id', '=', $client_id)
                ->update([
                    'nip'			=> $data->nip,
                    'name'			=> $data->name,
                    'position'		=> $data->position,
                    'updated_at'	=> $data->modified_by,
                    'updated_by'	=> $data->modified_date
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
            $officer = DB::table('tlibrary_officers')
                ->where('client_id', '=', $client_id)
                ->where('id', $id);

            return $officer->delete();
        });
    }
}