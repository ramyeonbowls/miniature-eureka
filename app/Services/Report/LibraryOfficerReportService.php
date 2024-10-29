<?php

namespace App\Services\Report;

use App\Repositories\Report\LibraryOfficerReportRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class LibraryOfficerReportService 
{
	private LibraryOfficerReportRepository $officer_repo;
    protected $client_id = '';

    public function __construct()
    {
        $this->officer_repo = new LibraryOfficerReportRepository();
        $this->client_id = config('app.client_id', '');
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function get($filter)
    {
        return new Collection($this->officer_repo->get($filter));
    }
}