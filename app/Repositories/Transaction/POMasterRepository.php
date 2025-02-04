<?php

namespace App\Repositories\Transaction;

use Carbon\Carbon;
use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class POMasterRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get($filter, $client_id, $db_platform): Collection
    {
        return DB::table($db_platform.'tpo_header as a')
            ->select(
                'b.instansi_name as wl_name',
                'b.provinsi_id',
                'c.provinsi_name',
                'b.kabupaten_id',
                'd.kabupaten_name',
                'a.po_number',
                DB::raw("CASE WHEN a.po_type = '1' THEN 'Penjualan' WHEN a.po_type = '2' THEN 'Hibah' ELSE '' END as po_type "),
                'a.po_date',
                'a.po_amount',
                'a.created_at'
            )
            ->join('tclient as b', function ($join) {
                $join->on('a.client_id', '=', 'b.client_id');
            })
            ->join('tprovinsi as c', function ($join) {
                $join->on('b.provinsi_id', '=', 'c.provinsi_id');
            })
            ->join('tkabupaten as d', function ($join) {
                $join->on('b.kabupaten_id', '=', 'd.kabupaten_id');
            })
            ->where('a.client_id', $client_id)
            ->where('a.status', 0)
            ->orderBy('b.instansi_name', 'ASC')
            ->get();
    }

	/**
     * @param array $data
     * @return bool
     */
    public function store(array $data, $client_id, $db_platform, $dist_id): bool
    {
        $failed = false;
        $po_amount = 0;
        DB::beginTransaction();

        foreach ($data['books'] as $val) {
            $po_amount += $val['qty'] * $val['sellprice'];
            $insert = DB::table($db_platform.'tpo_detail')->insert([
                'client_id' => $client_id,
                'po_number' => $data['po_number'],
                'po_date' => $data['po_date'],
                'book_id' => $val['book_id'],
                'qty' => $val['qty'],
                'sellprice' => $val['sellprice'],
                'created_at' => $data['create_date'],
                'created_by' => $data['create_by']
            ]);

            if(!$insert) {
                $failed = true;
            }
        }

        if(!$failed){
            $header = DB::table($db_platform.'tpo_header')->insert([
                'client_id' => $client_id,
                'po_number' => $data['po_number'],
                'po_date' => $data['po_date'],
                'po_type' => 1,
                'po_amount' => $po_amount,
                'distributor_id' => $dist_id,
                'po_discount' => 0,
                'status' => 0,
                'persentase_supplier' => 40,
                'created_at' => $data['create_date'],
                'created_by' => $data['create_by']
            ]);

            if(!$header) {
                $failed = true;
            }
        }

        if($failed) {
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
    public function update(array $data, string $po_number, $po_date, $client_id, $db_platform): bool
    {
        $failed = false;
        $po_amount = 0;
        DB::beginTransaction();

        DB::table($db_platform.'tpo_detail')
            ->where('client_id', $client_id)
            ->where('po_number', $po_number)
            ->delete();

        foreach ($data['books'] as $val) {
            $po_amount += $val['qty'] * $val['sellprice'];
            $insert = DB::table($db_platform.'tpo_detail')->insert([
                'client_id' => $client_id,
                'po_number' => $po_number,
                'po_date' => $po_date,
                'book_id' => $val['book_id'],
                'qty' => $val['qty'],
                'sellprice' => $val['sellprice'],
                'created_at' => $data['create_date'],
                'created_by' => $data['create_by']
            ]);

            if(!$insert) {
                $failed = true;
            }
        }

        if(!$failed){
            $updateHeader = DB::table($db_platform.'tpo_header')
                ->where('client_id', $client_id)
                ->where('po_number', $po_number)
                ->where('po_date', $po_date)
                ->update([
                    'po_amount' => $po_amount,
                    // 'updated_at' => $data['modified_date'],
                    // 'updated_by' => $data['modified_by']
                ]);

            if(!$updateHeader) {
                $failed = true;
            }
        }

        if($failed) {
            DB::rollBack();
            return false;
        }else{
            DB::commit();
            return true;
        }

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
    public function delete(string $po_number, $po_date, $client_id, $db_platform)
    {
        DB::beginTransaction();
        $detail = DB::table($db_platform.'tpo_detail')
            ->where('client_id', $client_id)
            ->where('po_number', $po_number)
            ->delete();
            
        $header = DB::table($db_platform.'tpo_header')
            ->where('client_id', $client_id)
            ->where('po_number', $po_number)
            ->delete();

        if ($detail && $header) {
            DB::commit();
            return true;
        } else {
            DB::rollBack();
            return false;
        }
    }

    public function getDetail($po_number, $po_date, $client_id, $db_platform): Collection
    {
        return DB::table($db_platform.'tpo_detail as a')
            ->select(
                'a.book_id',
                'a.qty',
                'a.sellprice',
                'b.title',
            )
            ->join('tbook as b', function ($join) {
                $join->on('a.book_id', '=', 'b.book_id');
            })
            ->where('a.po_number', '=', $po_number)
            ->where('a.po_date', '=', $po_date)
			->orderBy('a.po_number', 'ASC')
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