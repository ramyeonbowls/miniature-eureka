<?php

namespace App;

use App;
use Config;
use Artisan;
use Illuminate\Support\Facades\DB;

class Libraries 
{
	public static function isDinas()
	{
		$result['status']		= false;
		$result['category']		= '';
		$result['level']		= '';
		$result['country']		= '';
		$result['provinsi']		= '';
		$result['kabupaten']	= '';
		$client_id			= config('app.client_id', '');
		try {
			$parameter = DB::table('tclient as a')
				->select(
					'a.client_category',
					'a.client_level',
					'a.country_id',
					'a.provinsi_id',
					'a.kabupaten_id'
				)
				->where('a.client_id', $client_id)
				->sharedLock()
				->first();

			if($parameter) {
				$result['status']		= ($parameter->client_category == '1006') ? true : false;
				$result['category']		= $parameter->client_category;
				$result['level']		= $parameter->client_level;
				$result['country']		= $parameter->country_id;
				$result['provinsi']		= $parameter->provinsi_id;
				$result['kabupaten']	= $parameter->kabupaten_id;

				return $result;
			}
		} catch (\PDOException $e) {
			return $result;
		}
	}
}