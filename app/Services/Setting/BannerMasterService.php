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
}