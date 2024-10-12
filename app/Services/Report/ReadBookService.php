<?php

namespace App\Services\Report;

use App\Repositories\Report\ReadBookRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class ReadBookService 
{
	private ReadBookRepository $book_repo;
    protected $client_id = '';

    public function __construct()
    {
        $this->book_repo = new ReadBookRepository();
        $this->client_id = config('app.client_id', '');
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function get($filter)
    {
        return new Collection($this->book_repo->get($filter, $this->client_id));
    }
}