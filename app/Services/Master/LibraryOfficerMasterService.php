<?php

namespace App\Services\Master;

use App\Repositories\Master\LibraryOfficerMasterRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class LibraryOfficerMasterService 
{
	private LibraryOfficerMasterRepository $LibraryOfficer_repo;
    protected $client_id = '';

    public function __construct()
    {
        $this->LibraryOfficer_repo = new LibraryOfficerMasterRepository();
        $this->client_id = config('app.client_id', '');
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function get()
    {
        return new Collection($this->LibraryOfficer_repo->get($this->client_id));
    }

	/**
     * @param object $data
     * @return bool
     */
    public function store(object $data): bool
    {
        $datetime_now = Carbon::now("Asia/Jakarta");
        $username = auth()->user()->email;

        $data->created_by	= $username;
        $data->created_at	= $datetime_now;

        return $this->LibraryOfficer_repo->store($data, $this->client_id);
    }

	/**
     * @param object $data
     * @return bool
     */
    public function update(object $data, string $id): bool
    {
        $datetime_now = Carbon::now("Asia/Jakarta");
        $username = auth()->user()->email;

        $data->modified_date	= $username;
        $data->modified_by		= $datetime_now;

        return $this->LibraryOfficer_repo->update($data, $id, $this->client_id);
    }

	/**
     * @param string $id
     * @return mixed
     */
    public function delete(string $id)
    {
        return $this->LibraryOfficer_repo->delete($id, $this->client_id);
    }
}