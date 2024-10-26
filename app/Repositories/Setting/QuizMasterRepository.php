<?php

namespace App\Repositories\Setting;

use App\Models\IconMenu\IconMenu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class QuizMasterRepository 
{
	/**
     * @param array $filter
     * @return Collection
     */
    public function get($filter, $client_id): Collection
    {
        return DB::table('tquiz_h as a')
			->select(
				'a.id',
				'a.client_id',
				'a.title',
				'a.start_date',
				'a.end_date',
				'a.created_at',
				'a.created_by',
				'a.updated_at',
				'a.update_by',
			)
            ->where('a.client_id', '=', $client_id)
			->get();
    }

	/**
     * @param array $filter
     * @return Collection
     */
    public function getQuestion($id, $client_id): Collection
    {
        return DB::table('tquiz_question as a')
			->select(
				'a.*'
			)
            ->where('a.client_id', '=', $client_id)
            ->where('a.survey_id', '=', $id)
			->get();
    }

	/**
     * @param array $filter
     * @return Collection
     */
    public function getAnswer($id, $question_id, $client_id): Collection
    {
        return DB::table('tquiz_answer as a')
			->select(
				'a.*'
			)
            ->where('a.client_id', '=', $client_id)
            ->where('a.survey_id', '=', $id)
            ->where('a.question_id', '=', $question_id)
			->get();
    }

	/**
     * @param object $data
     * @return bool
     */
    public function store(object $data, $client_id): bool
    {
        return DB::transaction(function () use ($data, $client_id) {
			$success = true;

			$quiz_h = DB::table('tquiz_h')->insert([
				'client_id' => $client_id,
				'id' => $data->id,
				'title' => $data->title,
				'start_date' => $data->start_date,
				'end_date' => $data->end_date,
				'created_by' => $data->create_by,
				'created_at' => $data->create_date
			]);

            if ($quiz_h) {
				foreach ($data->questions as $q => $question) {
					$question_id	= $question['id'];
					$quiz_q			= DB::table('tquiz_question')->insert([
						'client_id' => $client_id,
						'survey_id' => $data->id,
						'id' => $question_id,
						'description' => $question['description'],
						'seq' => $question['template_sequence'],
						'required' => $question['required'],
						'type' => $question['type'],
						'point' => $question['point'],
						'created_by' => $data->create_by,
						'created_at' => $data->create_date
					]);

					if(!$quiz_q){
						$success = false;
					}

					$answer = $question['answer'];
					if (count($answer) > 1) {
						foreach ($answer as $a => $ans) {
							$answer_id	= intval($a + 1);
							$quiz_a		= DB::table('tquiz_answer')->insert([
								'client_id' => $client_id,
								'survey_id' => $data->id,
								'question_id' => $question_id,
								'id' => $answer_id,
								'description' => $ans['description'],
								'point' => $ans['point'] > 0 ? $ans['point'] : 0,
								'created_by' => $data->create_by,
								'created_at' => $data->create_date
							]);

							if(!$quiz_a){
								$success = false;
							}
						}
					}
				}
			}else{
				$success = false;
			}

			return $success;
        });
    }
	
	/**
     * @param object $data
     * @param string $id
     * @return bool
     */
    public function update(object $data, string $id, $client_id): bool
    {
        return DB::transaction(function () use ($data, $id, $client_id) {
			$success = true;

			$quiz_h = DB::table('tquiz_h')->where('id', $id)->where('client_id', '=', $client_id)
				->update([
				'title' => $data->title,
				'start_date' => $data->start_date,
				'end_date' => $data->end_date,
				'update_by' => $data->modified_by,
				'updated_at' => $data->modified_date
			]);

			if ($quiz_h) {
				$del_quiz_q = DB::table('tquiz_answer')->where('survey_id', $data->id)->where('client_id', '=', $client_id)->delete();
				$del_quiz_a = DB::table('tquiz_question')->where('survey_id', $data->id)->where('client_id', '=', $client_id)->delete();

				if(!$del_quiz_q && !$del_quiz_a){
					$success = false;
				}else{
					foreach ($data->questions as $q => $question) {
						$question_id	= $question['id'];
						$quiz_q			= DB::table('tquiz_question')->insert([
							'client_id' => $client_id,
							'survey_id' => $data->id,
							'id' => $question_id,
							'description' => $question['description'],
							'seq' => $question['template_sequence'],
							'required' => $question['required'],
							'type' => $question['type'],
							'point' => $question['point'],
							'created_by' => $data->create_by,
							'created_at' => $data->create_date
						]);
	
						if(!$quiz_q){
							$success = false;
						}
	
						$answer = $question['answer'];
						if (count($answer) > 1) {
							foreach ($answer as $a => $ans) {
								$answer_id	= intval($a + 1);
								$quiz_a		= DB::table('tquiz_answer')->insert([
									'client_id' => $client_id,
									'survey_id' => $data->id,
									'question_id' => $question_id,
									'id' => $answer_id,
									'description' => $ans['description'],
									'point' => $ans['point'] > 0 ? $ans['point'] : 0,
									'created_by' => $data->create_by,
									'created_at' => $data->create_date
								]);
	
								if(!$quiz_a){
									$success = false;
								}
							}
						}
					}
				}
			}else{
				$success = false;
			}

			return $success;
        });
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function delete(string $id, $client_id)
    {
        return DB::transaction(function () use ($id, $client_id) {
			$success = true;

            $quiz_h = DB::table('tquiz_h')
                ->where('client_id', '=', $client_id)
                ->where('id', $id);

			$quiz_q = DB::table('tquiz_question')
                ->where('client_id', '=', $client_id)
                ->where('survey_id', $id);

			$quiz_a = DB::table('tquiz_answer')
                ->where('client_id', '=', $client_id)
                ->where('survey_id', $id);

			if(!$quiz_h->delete() || !$quiz_q->delete() || !$quiz_a->delete()) $success = false;

            return $success;
        });
    }
}