<?php

namespace App\Services\Setting;

use App\Repositories\Setting\BannerMasterRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class BannerMasterService 
{
	private BannerMasterRepository $banner_repo;

    public function __construct()
    {
        $this->banner_repo = new BannerMasterRepository();
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function get(array $filter = []): Collection
    {
        return new Collection($this->banner_repo->get($filter));
    }

    /**
     * @param object $data
     * @return bool
     */
    public function store(object $data): bool
    {
        $datetime_now = Carbon::now("Asia/Jakarta");
        $username = auth()->user()->email;

        $data->create_by        = $username;
        $data->modified_by      = $username;
        $data->create_date      = $datetime_now;
        $data->modified_date    = $datetime_now;

        return $this->banner_repo->store($data);
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

        return $this->banner_repo->update($data, $id);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function delete(string $id)
    {
        return $this->banner_repo->delete($id);
    }
}