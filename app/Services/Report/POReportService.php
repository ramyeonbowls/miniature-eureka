<?php

namespace App\Services\Report;

use App\Repositories\Report\POReportRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class POReportService 
{
	private POReportRepository $PO_repo;
    protected $client_id = '';

    public function __construct()
    {
        $this->PO_repo = new POReportRepository();
        $this->client_id = config('app.client_id', '');
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function get($filter)
    {
        return new Collection($this->PO_repo->get($filter));
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function getDetail($filter)
    {
        return new Collection($this->PO_repo->getDetail($filter));
    }
}