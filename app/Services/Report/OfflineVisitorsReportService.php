<?php

namespace App\Services\Report;

use App\Repositories\Report\OfflineVisitorsReportRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class OfflineVisitorsReportService 
{
	private OfflineVisitorsReportRepository $visitors_repo;
    protected $client_id = '';

    public function __construct()
    {
        $this->visitors_repo = new OfflineVisitorsReportRepository();
        $this->client_id = config('app.client_id', '');
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function get($filter)
    {
        return new Collection($this->visitors_repo->get($filter));
    }
}