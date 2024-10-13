<?php

namespace App\Services\Report;

use App\Repositories\Report\MemberReportRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class MemberReportService 
{
	private MemberReportRepository $book_repo;
    protected $client_id = '';

    public function __construct()
    {
        $this->book_repo = new MemberReportRepository();
        $this->client_id = config('app.client_id', '');
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function get($filter)
    {
        return new Collection($this->book_repo->get($filter));
    }
}