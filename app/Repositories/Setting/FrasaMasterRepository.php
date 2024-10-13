<?php

namespace App\Repositories\Setting;

use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class FrasaMasterRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get($filter, $client_id): Collection
    {
        return DB::table('tfitur as a')
			->select(
				'a.id',
				'a.title',
				'a.description',
				'a.author',
				'a.file',
				'a.category',
				'a.flag_aktif',
				'a.flag_platform',
				'a.client_id',
				'a.created_at',
				'a.created_by',
				'a.updated_at',
				'a.update_by',
			)
            ->where('a.client_id', '=', $client_id)
            ->where('a.category', '=', 'FR')
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
            return DB::table('tfitur')->insert([
                'id'            => $data->id,
				'title'         => '',
				'description'   => $data->description,
				'author'        => $data->author,
				'file'          => $data->file,
				'category'      => 'FR',
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
            return DB::table('tfitur')->where('id', $id)->where('client_id', '=', $client_id)->where('category', '=', 'FR')

                ->update([
                    'title'         => '',
                    'description'   => $data->description,
                    'author'        => $data->author,
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
            $Frasa = DB::table('tfitur')
                ->where('client_id', '=', $client_id)
                ->where('category', '=', 'FR')
                ->where('id', $id);

            $Frasa_file = $Frasa->first();
            @unlink(storage_path('app/public/images/news/'.$Frasa_file->file));

            return $Frasa->delete();
        });
    }
}