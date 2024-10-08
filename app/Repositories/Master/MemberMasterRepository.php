<?php

namespace App\Repositories\Master;

use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class MemberMasterRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get($client_id): Collection
    {
        return DB::table('users as a')
			->select(
				'a.id',
				'b.nik',
				'b.photo',
				'a.name',
				'a.email',
				'b.phone',
				'b.birthday',
				'a.email_verified_at',
				'a.created_at'
			)
            ->join('tattr_member as b', function($join) {
                $join->on('a.id', '=', 'b.id');
            })
            ->where('a.client_id', '=', $client_id)
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
            return DB::table('users')->insert([
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
            return DB::table('users')->where('id', $id)
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
    public function delete(string $id, $client_id)
    {
        return DB::transaction(function () use ($id, $client_id) {
            $attr = DB::table('tattr_member')
                ->where('client_id', $client_id)
                ->where('id', $id);
            $attr_file = $attr->first();

            if($attr_file->photo!=''){
                @unlink(storage_path('app/public/images/profile/'.$attr_file->photo));
            }

            DB::table('tattr_member')->where('id', $id)->where('client_id', $client_id)->delete();

            $member = DB::table('users')->where('id', $id)->where('client_id', $client_id);

            return $member->delete();
        });
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function check(string $id, $client_id)
    {
        return DB::table('ttrx_read as a')
                ->select([
                    DB::raw('COUNT(DISTINCT a.book_id) AS total')
                ])
                ->where('a.client_id', $client_id)
                ->where('a.user_id', $id)
                ->get();
    }
}