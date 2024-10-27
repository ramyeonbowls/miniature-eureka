<?php

namespace App\Http\Controllers;

use App\Logs;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizTransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $client_id = '';
    public function __construct()
    {
        $this->middleware('auth');
        $this->client_id = config('app.client_id', '');
    }

    public function index()
    {
		$logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');
		DB::enableQueryLog();

		$user = auth()->user();

        $results = DB::table('tquiz_h as a')
            ->select([
                'a.id',
                'a.title',
                'a.end_date'
            ])
            ->where('a.client_id','=', $this->client_id)
            ->whereRaw("CONVERT(NOW(), DATE) BETWEEN a.start_date AND a.end_date")
            ->orderBy('created_at', 'DESC')
            ->get()
            ->map(function ($value) use ($user) {
				$cek_nilai	= $this->getResult($this->client_id, $value->id, $user->id);
				$nilai		= $cek_nilai->nilai;
				$finished	= ($cek_nilai->finished > 0 ? true : false);

                return [
                    'id'		=> $value->id,
                    'title'		=> $value->title,
                    'end_date'	=> $value->end_date,
                    'finished'	=> $finished,
                ];
            });

		$queries = DB::getQueryLog();
		for($q = 0; $q < count($queries); $q++) {
			$sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
			$logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
			$logs->write('SQL', $sql);
		}

        return response()->json($results, 200);
    }

	public function getDetailQuiz(Request $request)
    {
		$logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');
		DB::enableQueryLog();

		$user = auth()->user();

        $results['header'] = DB::table('tquiz_h as a')
            ->select([
                'a.id',
                'a.title',
                'a.end_date'
            ])
            ->where('a.client_id','=', $this->client_id)
            ->where('a.id','=', $request->id)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->map(function ($value) {
                return [
                    'id'		=> $value->id,
                    'title'		=> $value->title,
                    'end_date'	=> $value->end_date,
                ];
            });

		$results['questions'] = [];
		$quizq = DB::table('tquiz_question as a')
			->select(
				'a.*'
			)
			->where('a.client_id', '=', $this->client_id)
			->where('a.survey_id', '=', $request->id)
			->get();

		$cek_nilai				= $this->getResult($this->client_id, $request->id, $user->id);
		$results['nilai']		= $cek_nilai->nilai;
		$results['finished']	= ($cek_nilai->finished > 0 ? true : false);

		foreach ($quizq as $i => $question) {
			$results['questions'][$i]['id']           		= $question->id;
			$results['questions'][$i]['description']  		= $question->description;
			$results['questions'][$i]['template_sequence']  = $question->seq;
			$results['questions'][$i]['required']     		= (boolean) $question->required;
			$results['questions'][$i]['type']         		= $question->type;
			$results['questions'][$i]['point']        		= $question->point;
			$results['questions'][$i]['answer']       		= [];

			if($results['finished']){
				$rst = DB::table('tquiz_trx as a')
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
					->where('a.client_id', '=', $this->client_id)
					->where('a.survey_id', '=', $request->id)
					->where('a.user_id', '=', $user->id)
					->where('a.question_id', '=', $question->id)
					->get();
				foreach ($rst as $iii => $answer) {
					$results['questions'][$i]['answer'][$iii]['id']            = $answer->answer_id;
					$results['questions'][$i]['answer'][$iii]['description']   = $answer->description;
					$results['questions'][$i]['answer'][$iii]['point']         = $answer->point;
				}
			}else{
				$quiza = DB::table('tquiz_answer as a')
					->select(
						'a.*'
					)
					->where('a.client_id', '=', $this->client_id)
					->where('a.survey_id', '=', $request->id)
					->where('a.question_id', '=', $question->id)
					->get();
	
				foreach ($quiza as $ii => $answer) {
					$results['questions'][$i]['answer'][$ii]['id']            = $answer->id;
					$results['questions'][$i]['answer'][$ii]['description']   = $answer->description;
					$results['questions'][$i]['answer'][$ii]['point']         = $answer->point;
				}
			}
		}

		$queries = DB::getQueryLog();
		for($q = 0; $q < count($queries); $q++) {
			$sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
			$logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
			$logs->write('SQL', $sql);
		}

        return response()->json($results, 200);
    }

    public function store(Request $request)
    {
        Carbon::setLocale('id');
        $user = auth()->user();

        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        try {
            DB::enableQueryLog();
            \DB::beginTransaction();

			$success = true;
			$quiz_id = $request->id;
			foreach ($request->answers as $key => $value) {
				$insert = DB::table('tquiz_trx')->insert([
					'client_id'		=> $this->client_id,
					'user_id'		=> $user->id,
					'survey_id'		=> $quiz_id,
					'question_id'	=> $value['questionId'],
					'answer_id'		=> $value['selectedAnswer'],
					'type'			=> $value['type'],
					'point'			=> $value['answerPoint'],
					'created_at'    => Carbon::now('Asia/Jakarta')
				]);

				if(!$insert){
					$success = false;
				}
			}

			$queries = DB::getQueryLog();
            for($q = 0; $q < count($queries); $q++) {
                $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $sql);
            }

			if($success){
				\DB::commit();
				$logs->write("SUCCESS", 'COMMIT');
				$logs->write(__FUNCTION__, "STOP\r\n");
				
				return response()->json('successfully completed the quiz!.', 201);
			}else{
				\DB::rollBack();
				$logs->write("ERROR", 'ROLLBACK');
				$logs->write(__FUNCTION__, "STOP\r\n");

				return response()->json('failed to complete the quiz! Please try again.', 500);
			}
        } catch (\Exception $e) {
            $logs->write("ERROR", $e->getMessage());
            \DB::rollBack();

            return response()->json('failed to complete the quiz! Please try again.', 500);
        }
    }

	private function getResult($client_id, $survey_id, $user_id){
		return DB::table('tquiz_trx as a')
			->select(
				DB::raw("SUM(a.point) as nilai"),
				DB::raw("COUNT(a.question_id) as finished")
			)
			->where('a.client_id', '=', $client_id)
			->where('a.survey_id', '=', $survey_id)
			->where('a.user_id', '=', $user_id)
			->first();
	}
}
