<?php

namespace App\Services\Master;

use App\Repositories\Master\MemberMasterRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class MemberMasterService 
{
	private MemberMasterRepository $member_repo;

    public function __construct()
    {
        $this->member_repo = new MemberMasterRepository();
        $this->client_id = config('app.client_id', '');
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function get(): Collection
    {
        return new Collection($this->member_repo->get($this->client_id));
    }

    /**
     * @param object $data
     * @return bool
     */
    public function store(object $data): bool
    {
        $datetime_now = Carbon::now("Asia/Jakarta");

        $data->create_date      = $datetime_now;
        $data->modified_date    = $datetime_now;

        return $this->member_repo->store($data, $this->client_id);
    }

     /**
     * @param object $data
     * @param string $id
     * @return bool
     */
    public function update(object $data, string $id): bool
    {
        $datetime_now = Carbon::now("Asia/Jakarta");
        $username = auth()->user()->email;

        $data->file = $data->file ?? $data->current_file;

        $data->modified_by 		= $username;
        $data->modified_date 	= $datetime_now;

        return $this->member_repo->update($data, $id);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function delete(string $id)
    {
        return $this->member_repo->delete($id, $this->client_id);
    }
    
    /**
     * @param string $id
     * @return mixed
     */
    public function check(string $id)
    {
        return $this->member_repo->check($id, $this->client_id);
    }
}