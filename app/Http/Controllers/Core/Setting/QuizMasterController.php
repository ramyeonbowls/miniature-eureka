<?php

namespace App\Http\Controllers\Core\Setting;

use App\Logs;
use Exception;
use Throwable;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Services\Setting\QuizMasterService;
use App\Http\Requests\Setting\StoreQuizMasterRequest;
use App\Http\Requests\Setting\UpdateQuizMasterRequest;

class QuizMasterController extends Controller
{
    private QuizMasterService $Quiz_service;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->Quiz_service = new QuizMasterService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request): JsonResponse
    {
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $results = [];
        try {
            DB::enableQueryLog();

            $results = $this->Quiz_service->get();

            $queries = DB::getQueryLog();
			for($q = 0; $q < count($queries); $q++) {
				$sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
				$logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
				$logs->write('SQL', $sql);
			}
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        return DataTables::of($results)
            ->escapeColumns()
            ->editColumn('created_at', function ($value) {
                return Carbon::parse($value->created_at)->toDateTimeString();
            })
            ->editColumn('updated_at', function ($value) {
                return Carbon::parse($value->updated_at)->toDateTimeString();
            })
            ->addIndexColumn()
            ->toJson();
    }

    public function store(Request $request)
    {
		$request->validate([
            'id' => 'required|max:50',
            'title' => 'required',
            'start_date' => 'required|max:19',
            'end_date' => 'required|max:19',
            'questions.*.id' => 'required|max:20',
            'questions.*.description' => 'required',
            'questions.*.type' => 'required',
            'questions.*.answer.*.description' => 'required_if:questions.*.type,multiple,checklist'
        ],[
            'questions.*.id.required' => 'The id field is required.',
            'questions.*.id.max' => 'The id field max. 20 characters.',
            'questions.*.description.required' => 'The question field is required.',
            'questions.*.type.required' => 'The type field is required.',
            'questions.*.answer.*.description.required_if' => 'The answer field is required'
        ]);

        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $result['status'] = 200;
        $result['message'] = '';

        try {
            DB::enableQueryLog();

            $created = $this->Quiz_service->store((object)$request);
            if ($created) {
                $logs->write("INFO", "Successfully created");

                $result['status'] = 201;
                $result['message'] = "Data berhasil dibuat.";
            }

            $queries = DB::getQueryLog();
			for($q = 0; $q < count($queries); $q++) {
				$sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
				$logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
				$logs->write('SQL', $sql);
			}
        } catch (Throwable $th) {
			$sqlState   = $th->errorInfo[0];
			$errCode    = $th->errorInfo[1];
			$errMessage = $th->errorInfo[2];
            $logs->write("ERROR", $th->getMessage());

            $result['message'] = "Data gagal dibuat.<br>" . $errMessage;
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($result['message'], $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show($id)
    {
		$logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');
		DB::enableQueryLog();

		$quiz_q = $this->Quiz_service->getQuestion($id);
		$results['questions'] = [];
		foreach ($quiz_q as $i => $question) {
			$results['questions'][$i]['editable']     		= false;
            $results['questions'][$i]['id']           		= $question->id;
            $results['questions'][$i]['description']  		= $question->description;
            $results['questions'][$i]['template_sequence']  = $question->seq;
            $results['questions'][$i]['required']     		= (boolean) $question->required;
            $results['questions'][$i]['type']         		= $question->type;
            $results['questions'][$i]['point']        		= $question->point;
            $results['questions'][$i]['flag_new']     		= ($i==($quiz_q->count() - 1)) ? true : false;
            $results['questions'][$i]['visible']      		= true;
            $results['questions'][$i]['answer']       		= [];

			$quiz_a = $this->Quiz_service->getAnswer($id, $question->id);
			foreach ($quiz_a as $ii => $answer) {
        		$results['questions'][$i]['answer'][$ii]['id']            = $answer->id;
        		$results['questions'][$i]['answer'][$ii]['description']   = $answer->description;
				$results['questions'][$i]['answer'][$ii]['point']         = $answer->point;
				$results['questions'][$i]['answer'][$ii]['flag_new']      = ($ii==0) ? true : false;
        	}
		}

		$queries = DB::getQueryLog();
		for($q = 0; $q < count($queries); $q++) {
			$sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
			$logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
			$logs->write('SQL', $sql);
		}
        $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($results, 200);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'id' => 'required|max:50',
            'title' => 'required',
            'start_date' => 'required|max:19',
            'end_date' => 'required|max:19',
            'questions.*.id' => 'required|max:20',
            'questions.*.description' => 'required',
            'questions.*.type' => 'required',
            'questions.*.answer.*.description' => 'required_if:questions.*.type,multiple,checklist'
        ],[
            'questions.*.id.required' => 'The id field is required.',
            'questions.*.id.max' => 'The id field max. 20 characters.',
            'questions.*.description.required' => 'The question field is required.',
            'questions.*.type.required' => 'The type field is required.',
            'questions.*.answer.*.description.required_if' => 'The answer field is required'
        ]);

        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $result['status'] = 200;
        $result['message'] = '';
        try {
            DB::enableQueryLog();

            $updated = $this->Quiz_service->update((object)$request, $id);
            if ($updated) {
                $logs->write("INFO", "Successfully updated");

                $result['status'] = 201;
                $result['message'] = "Data berhasil diperbarui.";
            }

            $queries = DB::getQueryLog();
			for($q = 0; $q < count($queries); $q++) {
				$sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
				$logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
				$logs->write('SQL', $sql);
			}
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $result['message'] = "Data gagal diperbarui.<br>" . $th->getMessage();
        }

        return response()->json($result['message'], $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $result['status'] = 200;
        $result['message'] = '';
        try {
            DB::enableQueryLog();

            $deleted = $this->Quiz_service->delete($id);

            $queries = DB::getQueryLog();
			for($q = 0; $q < count($queries); $q++) {
				$sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
				$logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
				$logs->write('SQL', $sql);
			}

            if ($deleted) {
                $result['message'] = 'Data berhasil dihapus';
            }
        } catch (Throwable $th) {
			$sqlState   = $th->errorInfo[0];
			$errCode    = $th->errorInfo[1];
			$errMessage = $th->errorInfo[2];
            $logs->write("ERROR", $th->getMessage());

            $result['message'] = 'Data gagal dihapus.<br>' . $errMessage;
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($result['message'], $result['status']);
    }
}
