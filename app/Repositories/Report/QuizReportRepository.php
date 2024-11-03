<?php

namespace App\Repositories\Report;

use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class QuizReportRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get($filter): Collection
    {
        $client_id = $this->getClientID($filter);
        extract($filter);

        return DB::table('tquiz_trx as a')
            ->select(
                'b.instansi_name as wl_name',
                'b.provinsi_id',
                'c.provinsi_name',
                'b.kabupaten_id',
                'd.kabupaten_name',
                'e.id',
                'e.name',
                'a.survey_id',
                'f.title',
                DB::raw("SUM(a.point) AS point"),
                'a.created_at AS tgl'
            )
            ->join('tclient as b', function ($join) {
                $join->on('a.client_id', '=', 'b.client_id');
            })
            ->join('tprovinsi as c', function ($join) {
                $join->on('b.provinsi_id', '=', 'c.provinsi_id');
            })
            ->join('tkabupaten as d', function ($join) {
                $join->on('b.kabupaten_id', '=', 'd.kabupaten_id');
            })
            ->join('users as e', function ($join) {
                $join->on('a.user_id', '=', 'e.id')
                    ->on('a.client_id', '=', 'e.client_id');
            })
            ->join('tquiz_h as f', function ($join) {
                $join->on('a.survey_id', '=', 'f.id')
                    ->on('a.client_id', '=', 'f.client_id');
            })
            ->where('a.client_id', '=', $client_id)
            ->where('b.provinsi_id', '=', $PROVINSI)
            ->where('b.kabupaten_id', '=', $KABUPATEN)
            ->where('f.created_by', '=', $created_by)
			->when(!empty($END_DATE), function ($query) use ($START_DATE, $END_DATE) {
                return $query->whereBetween(DB::raw('DATE(a.created_at)'), [$START_DATE, $END_DATE]);
            }, function ($query) use ($START_DATE) {
                return $query->where(DB::raw('DATE(a.created_at)'), '=', $START_DATE);
            })
			->groupBy('b.instansi_name', 'b.provinsi_id', 'c.provinsi_name', 'b.kabupaten_id', 'd.kabupaten_name', 'e.id', 'e.name', 'a.survey_id', 'f.title', 'a.created_at')
            ->get();
    }

    private function getClientID($filter)
    {
        extract($filter);

        $query = DB::table('tclient as a')
            ->select(
                'a.client_id'
            )
            ->where('a.provinsi_id', '=', $PROVINSI)
            ->where('a.kabupaten_id', '=', $KABUPATEN)
            ->where('a.instansi_name', '=', $WL)
            ->sharedLock()
            ->get();
        return $query[0]->client_id ?? '';
    }

    public function getQuestion($filter)
    {
        extract($filter);
		$client_id = $this->getClientID($filter);

        return DB::table('tquiz_question as a')
			->select(
				'a.*'
			)
			->where('a.client_id','=', $client_id)
			->where('a.survey_id','=', $survey_id)
			->get();
    }

	public function getAnswer($filter, $question_id)
    {
        extract($filter);
		$client_id = $this->getClientID($filter);

        return DB::table('tquiz_trx as a')
			->select(
				'a.*',
				'b.description',
				'b.point'
			)
			->leftjoin('tquiz_answer as b', function($join) {
				$join->on('a.client_id', '=', 'b.client_id')
					->on('a.survey_id', '=', 'b.survey_id')
					->on('a.question_id', '=', 'b.question_id')
					->on('a.answer_id', '=', 'b.id');
			})
			->where('a.client_id', '=', $client_id)
			->where('a.survey_id', '=', $survey_id)
			->where('a.user_id', '=', $id)
			->where('a.question_id', '=', $question_id)
			->get();
    }
}