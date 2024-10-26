<?php

namespace App\Services\Report;

use App\Repositories\Report\ReadFiturReportRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class ReadFiturReportService 
{
	private ReadFiturReportRepository $ReadFitur_repo;
    protected $client_id = '';

    public function __construct()
    {
        $this->ReadFitur_repo = new ReadFiturReportRepository();
        $this->client_id = config('app.client_id', '');
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function get($filter)
    {
        return new Collection($this->ReadFitur_repo->get($filter));
    }
}