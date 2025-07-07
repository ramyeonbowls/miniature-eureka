<?php

namespace App\Services\Master;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Master\MasterTitikBacaRepository;

class MasterTitikBacaService 
{
	private MasterTitikBacaRepository $titik_repo;

    public function __construct()
    {
        $this->titik_repo = new MasterTitikBacaRepository();
        $this->client_id = config('app.client_id', '');
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function get(array $filter = []): Collection
    {
        $filter['client_id'] = $this->client_id;
        return new Collection($this->titik_repo->get($filter));
    }

    /**
     * @param array $data
     * @return bool
     */
    public function store(array $data): bool
    {
        $datetime_now = Carbon::now("Asia/Jakarta");
        $username = auth()->user()->email;
        
        $data['create_by']        = $username;
        $data['modified_by']      = $username;
        $data['create_date']      = $datetime_now;
        $data['modified_date']    = $datetime_now;
        $data['uuid']             = Str::uuid();
        $data['client_id']        = $this->client_id;

        return $this->titik_repo->store($data);
    }

     /**
     * @param array $data
     * @param string $id
     * @return bool
     */
    public function update(array $data, string $id): bool
    {
        $datetime_now = Carbon::now("Asia/Jakarta");
        $username = auth()->user()->email;

        $data['create_by']        = $username;
        $data['modified_by']      = $username;
        $data['create_date']      = $datetime_now;
        $data['modified_date']    = $datetime_now;

        return $this->titik_repo->update($data, $id, $this->client_id);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function delete(string $id)
    {
        return $this->titik_repo->delete($id, $this->client_id);
    }

    public function getDetail($id): Collection
    {
        return new Collection($this->titik_repo->getDetail($id, $this->client_id));
    }
}