<?php

namespace App\Services\Report;

use App\Repositories\Report\LoansReportRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class LoansReportService 
{
	private LoansReportRepository $loans_repo;
    protected $client_id = '';

    public function __construct()
    {
        $this->loans_repo = new LoansReportRepository();
        $this->client_id = config('app.client_id', '');
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function get($filter)
    {
        return new Collection($this->loans_repo->get($filter));
    }
}