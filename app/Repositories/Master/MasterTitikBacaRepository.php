<?php

namespace App\Repositories\Master;

use Carbon\Carbon;
use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MasterTitikBacaRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get($filter): Collection
    {
        return DB::table('ttitik_baca as a')
            ->select(
                'a.id',
                'a.name',
                'a.created_at',
                'a.updated_at',
            )
            ->join('tclient as b', function ($join) {
                $join->on('a.client_id', '=', 'b.client_id');
            })
            ->where('a.client_id', $filter['client_id'])
            ->where('a.flag_delete', 'N')
            ->get();
    }

	/**
     * @param array $data
     * @return bool
     */
    public function store(array $data): bool
    {
        $failed = false;
        DB::beginTransaction();
        
        $titik = DB::table('ttitik_baca')->insert([
            'id' => $data['uuid'],
            'client_id' => $data['client_id'],
            'name' => $data['name'],
            'created_at' => $data['create_date'],
            'updated_at' => $data['modified_date'],
        ]);

        if ($titik) {
            foreach ($data['books'] as $val) {
                $insert = DB::table('tmapping_book_titik_baca')->insert([
                    'client_id' => $data['client_id'],
                    'titik_baca' => $data['uuid'],
                    'book_id' => $val['book_id'],
                    'copy' => $val['qty'],
                    'created_at' => $data['create_date'],
                    'updated_at' => $data['modified_date'],
                ]);

                if(!$insert) {
                    $failed = true;
                }
            }

            $userTitik = DB::table('user_by_titikbaca')->insert([
                    'email' => $data['uuid'] . '@mail.com',
                    'client_id' => $data['client_id'],
                    'id' => $data['uuid'],
                ]);

            $user = DB::table('users')->insert([
                    'name' => $data['name'],
                    'email' => $data['uuid'] . '@mail.com',
                    'email_verified_at' => $data['create_date'],
                    'password' => Hash::make('123456789'),
                    'created_at' => $data['create_date'],
                    'updated_at' => $data['modified_date'],
                    'role' => 'member',
                    'client_id' => $data['client_id'],
                    'flag_approve' => 'Y',
                ]);

            $user = DB::table('users')->select('id')->where('email', $data['uuid'] . '@mail.com')->first();
            $attribute = DB::table('tattr_member')->insert([
                'id' => $user->id,
                'client_id' => $data['client_id'],
                'birthday' => '1800-01-01',
                'created_at' => $data['create_date'],
                'updated_at' => $data['modified_date'],
                'gender' => 'L',
            ]);
        } else {
            $failed = true;
        }

        if ($failed) {
            DB::rollBack();
            return false;
        }else{
            DB::commit();
            return true;
        }

    }
	
	/**
     * @param array $data
     * @param string $id
     * @return bool
     */
    public function update(array $data, string $id, $client_id): bool
    {
        $failed = false;
        DB::beginTransaction();

        $titik = DB::table('ttitik_baca')
        ->where('id', $id)
        ->where('client_id', $client_id)
        ->update([
            'name' => $data['name'],
            'updated_at' => $data['modified_date'],
        ]);

        if ($titik) {
            DB::table('tmapping_book_titik_baca')->where('titik_baca', $id)->where('client_id', $client_id)->delete();

            foreach ($data['books'] as $val) {
                $insert = DB::table('tmapping_book_titik_baca')->insert([
                    'client_id' => $client_id,
                    'titik_baca' => $id,
                    'book_id' => $val['book_id'],
                    'copy' => $val['qty'],
                    'created_at' => $data['create_date'],
                    'updated_at' => $data['modified_date'],
                ]);

                if(!$insert) {
                    $failed = true;
                }
            }
        } else {
            $failed = true;
        }

        if ($failed) {
            DB::rollBack();
            return false;
        }else{
            DB::commit();
            return true;
        }
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function delete(string $id, $client_id)
    {
        DB::beginTransaction();
        $delete = DB::table('ttitik_baca')
            ->where('id', $id)
            ->where('client_id', $client_id)
            ->update([
                'flag_delete' => 'Y',
                'updated_at' => Carbon::now("Asia/Jakarta"),
            ]);

        if ($delete) {
            DB::commit();
            return true;
        } else {
            DB::rollBack();
            return false;
        }
    }

    public function getDetail($id, $client_id): Collection
    {
        return DB::table('tmapping_book_titik_baca as a')
            ->select(
                'a.book_id',
                'a.copy as qty',
                DB::raw('a.copy + (a.copy - ifnull(c.copy, 0)) as mqty'),
                'b.sellprice as sellprice',
                'b.title',
            )
            ->join('tbook as b', function ($join) {
                $join->on('a.book_id', '=', 'b.book_id');
            })
            ->join('tmapping_book as c', function ($join) {
                $join->on('a.book_id', '=', 'c.book_id')
                    ->on('a.client_id', '=', 'c.client_id');
            })
            ->where('a.client_id', '=', $client_id)
            ->where('a.titik_baca', '=', $id)
            ->get();
    }

    public function getDistId($client_id)
    {
        return DB::table('tclient as a')
            ->select(
                'a.company_id'
            )
            ->where('a.client_id', '=', $client_id)
            ->first();
    }
}