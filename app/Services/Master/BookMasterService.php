<?php

namespace App\Services\Master;

use App\Repositories\Master\BookMasterRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class BookMasterService 
{
	private BookMasterRepository $book_repo;
    protected $client_id = '';

    public function __construct()
    {
        $this->book_repo = new BookMasterRepository();
        $this->client_id = config('app.client_id', '');
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function get()
    {
        return new Collection($this->book_repo->get($this->client_id));
    }
}