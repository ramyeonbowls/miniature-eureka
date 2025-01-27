<?php

namespace App\Services\Master;

use App\Repositories\Master\TeacherMasterRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class TeacherMasterService 
{
	private TeacherMasterRepository $Teacher_repo;

    public function __construct()
    {
        $this->Teacher_repo = new TeacherMasterRepository();
        $this->client_id = config('app.client_id', '');
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function get(): Collection
    {
        return new Collection($this->Teacher_repo->get($this->client_id));
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

        return $this->Teacher_repo->store($data, $this->client_id);
    }

    /**
     * @param object $data
     * @return bool
     */
    public function create(object $data): bool
    {
        $datetime_now = Carbon::now("Asia/Jakarta");

        $data->create_date      = $datetime_now;
        $data->modified_date    = $datetime_now;

        return $this->Teacher_repo->create($data, $this->client_id);
    }

     /**
     * @param object $data
     * @param string $id
     * @return bool
     */
    public function update(object $data, string $id): bool
    {
        $datetime_now = Carbon::now("Asia/Jakarta");
        $username   = auth()->user()->email;

        $data->modified_by 		= $username;
        $data->modified_date 	= $datetime_now;

        return $this->Teacher_repo->update($data, $id, $this->client_id);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function delete(string $id)
    {
        return $this->Teacher_repo->delete($id, $this->client_id);
    }
}