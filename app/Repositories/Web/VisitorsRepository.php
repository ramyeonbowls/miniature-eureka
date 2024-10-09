<?php

namespace App\Repositories\Web;

use Carbon\Carbon;
use App\Models\Web\Visitors;
use Illuminate\Support\Facades\DB;
use Browser;

class VisitorsRepository 
{
	public function createVisitor($data)
	{
		Carbon::setLocale('id');
		$date = Carbon::now('Asia/Jakarta')->format('Y-m-d');
		$client_id = config('app.client_id', '');

		try {
			Visitors::updateOrCreate(
				[
					'client_id' => $client_id,
					'date' => $date,
					'visitor' => $data->getClientIp(),
				],
				[
					'platform' => Browser::platformFamily(),
					'device' => Browser::isDesktop() ? 'Desktop' : Browser::deviceFamily(),
					'browser' => Browser::browserFamily(),
					'browser_name' => Browser::browserName(),
					'user_agent' => Browser::userAgent(),
					'updated_at' => Carbon::now('Asia/Jakarta')
				]
			);

			return true;
		} catch (\Exception $e) {
			\Log::error('Access member log failed => ' . $e->getMessage());
        	return false;
		}
	}
}