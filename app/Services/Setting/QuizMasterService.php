<?php

namespace App\Services\Setting;

use App\Repositories\Setting\QuizMasterRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class QuizMasterService 
{
	private QuizMasterRepository $Quiz_repo;

    protected $client_id = '';
    public function __construct()
    {
        $this->Quiz_repo = new QuizMasterRepository();
        $this->client_id = config('app.client_id', '');
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function get(array $filter = []): Collection
    {
        return new Collection($this->Quiz_repo->get($filter, $this->client_id));
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function getQuestion($id): Collection
    {
        return new Collection($this->Quiz_repo->getQuestion($id, $this->client_id));
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function getAnswer($id, $question_id): Collection
    {
        return new Collection($this->Quiz_repo->getAnswer($id, $question_id, $this->client_id));
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
        $data->create_date      = $datetime_now;

        return $this->Quiz_repo->store($data, $this->client_id);
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

        $data->modified_by 		= $username;
        $data->modified_date 	= $datetime_now;

        return $this->Quiz_repo->update($data, $id, $this->client_id);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function delete(string $id)
    {
        return $this->Quiz_repo->delete($id, $this->client_id);
    }
}