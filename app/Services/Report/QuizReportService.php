<?php

namespace App\Services\Report;

use App\Repositories\Report\QuizReportRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class QuizReportService 
{
	private QuizReportRepository $loans_repo;
    protected $client_id = '';

    public function __construct()
    {
        $this->loans_repo = new QuizReportRepository();
        $this->client_id = config('app.client_id', '');
    }

    /**
     * @param array $filter
     * @return Collection
     */
    public function get($filter)
    {
        return new Collection($this->loans_repo->get($filter));
    }

	/**
     * @param array $filter
     * @return Collection
     */
    public function getQuestion($filter)
    {
        return new Collection($this->loans_repo->getQuestion($filter));
    }

	/**
     * @param array $filter
     * @return Collection
     */
    public function getAnswer($filter, $question_id)
    {
        return new Collection($this->loans_repo->getAnswer($filter, $question_id));
    }
}