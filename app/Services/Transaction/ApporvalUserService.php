<?php

namespace App\Services\Transaction;

use App\Repositories\Transaction\ApporvalUserRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class ApporvalUserService 
{
	private ApporvalUserRepository $user_repo;

    public function __construct()
    {
        $this->user_repo = new ApporvalUserRepository();
        $this->client_id = config('app.client_id', '');
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function get(): Collection
    {
        return new Collection($this->user_repo->get($this->client_id));
    }

	/**
     * @param array $data
     * @return bool
     */
    public function store(array $data): bool
    {
        return $this->user_repo->store($data, $this->client_id);
    }
}