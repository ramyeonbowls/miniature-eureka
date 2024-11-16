<?php

namespace App\Repositories\Transaction;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApporvalUserRepository 
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
            ->where('a.role', '=', 'member')
            ->where('a.flag_approve', '=', 'N')
			->get();
    }

	/**
     * @param array $data
     * @return bool
     */
    public function store(array $data, $client_id): bool
    {
        return DB::transaction(function () use ($data, $client_id) {
			foreach ($data as $key => $value) {
				$appr = DB::table('users')
				->where('id', $value['id'])
				->where('client_id', $client_id)
                ->update([
                    'flag_approve' => 'Y',
                    'updated_at' => Carbon::now("Asia/Jakarta"),
                ]);
			}

			return $appr;
        });
    }
}