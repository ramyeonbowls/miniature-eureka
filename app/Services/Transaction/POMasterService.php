<?php

namespace App\Services\Transaction;

use App\Repositories\Transaction\POMasterRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class POMasterService 
{
	private POMasterRepository $PO_repo;

    protected $client_id = '';
    public function __construct()
    {
        $this->PO_repo = new POMasterRepository();
        $this->client_id = config('app.client_id', '');
        $this->db_platorm = config('app.db_platform', '').'.';
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function get(array $filter = []): Collection
    {
        return new Collection($this->PO_repo->get($filter, $this->client_id, $this->db_platorm));
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
        $data['po_date']          = $datetime_now->format('Y-m-d');
        $data['po_number']        = 'PO-'.$datetime_now->format('YmdHis');
        $company                  = $this->PO_repo->getDistId($this->client_id);
        $dist_id                  = $company->company_id;

        return $this->PO_repo->store($data, $this->client_id, $this->db_platorm, $dist_id);
    }

     /**
     * @param array $data
     * @param string $id
     * @return bool
     */
    public function update(array $data, string $po_number, $po_date): bool
    {
        $datetime_now = Carbon::now("Asia/Jakarta");
        $username = auth()->user()->email;

        $data['create_by']        = $username;
        $data['modified_by']      = $username;
        $data['create_date']      = $datetime_now;
        $data['modified_date']    = $datetime_now;

        return $this->PO_repo->update($data, $po_number, $po_date, $this->client_id, $this->db_platorm);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function delete(string $po_number, $po_date)
    {
        return $this->PO_repo->delete($po_number, $po_date, $this->client_id, $this->db_platorm);
    }

    public function getDetail($po_number, $po_date): Collection
    {
        return new Collection($this->PO_repo->getDetail($po_number, $po_date, $this->client_id, $this->db_platorm));
    }
}