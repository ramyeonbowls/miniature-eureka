<?php

namespace App\Http\Controllers\Core\Report;

use App\Logs;
use Exception;
use Throwable;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Report\QuizReportExport;
use App\Services\Report\QuizReportService;
use Yajra\DataTables\Facades\DataTables;

class QuizReportController extends Controller
{
    private QuizReportService $loans_service;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->loans_service = new QuizReportService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request): JsonResponse
    {
        if($request->has('nodata')) {
            return DataTables::of([])->toJson();
        }

        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');
		$user = auth()->user();

        $results = [];
        try {
            DB::enableQueryLog();

            $filter['PROVINSI']     = $request->PROVINSI ?? '';
            $filter['KABUPATEN']    = $request->KABUPATEN ?? '';
            $filter['WL']           = $request->WL ?? '';
            $filter['START_DATE']   = $request->START_DATE ?? '';
            $filter['END_DATE']     = $request->END_DATE ?? '';
            $filter['created_by']	= $user->email;

            $results = $this->loans_service->get($filter);

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
            ->addIndexColumn()
            ->toJson();
    }

    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function show(string $id): JsonResponse
    {
        return response()->json($id, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        //
    }

    public function ExportXLS(Request $request)
    {
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $results = [];
        try {
            DB::enableQueryLog();

            $filter['PROVINSI']     = $request->PROVINSI ?? '';
            $filter['KABUPATEN']    = $request->KABUPATEN ?? '';
            $filter['WL']           = $request->WL ?? '';
            $filter['START_DATE']   = $request->START_DATE ?? '';
            $filter['END_DATE']     = $request->END_DATE ?? '';

            $this->loans_service->get($filter)->map(function($value, $i) use (&$results) {
                $results[$i]['wl_name']			= $value->wl_name;
                $results[$i]['provinsi_name']	= $value->provinsi_name;
                $results[$i]['kabupaten_name']	= $value->kabupaten_name;
    			$results[$i]['name']			= $value->name;
    			$results[$i]['title']			= $value->title;
    			$results[$i]['point']			= $value->point;
    			$results[$i]['tgl']				= $value->tgl;
            });
        } catch (\Exception $e) {
            $logs->write("ERROR", $e->getMessage());
        }

        $queries = DB::getQueryLog();
        for($q = 0; $q < count($queries); $q++) {
            $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
            $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
            $logs->write('SQL', $sql);
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        return Excel::download(new QuizReportExport($results), 'Laporan_Baca_Buku.xlsx');
    }

	/**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function detail(Request $request): JsonResponse
    {
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $results = [];
        try {
            DB::enableQueryLog();

            $filter['PROVINSI']     = $request->PROVINSI ?? '';
            $filter['KABUPATEN']    = $request->KABUPATEN ?? '';
            $filter['WL']           = $request->WL ?? '';
			$filter['id']			= $request->id ?? '';
            $filter['date']			= $request->date ?? '';
            $filter['survey_id']	= $request->survey_id ?? '';

			$results['questions']	= [];
            $quizq					= $this->loans_service->getQuestion($filter);

			foreach ($quizq as $i => $question) {
				$results['questions'][$i]['id']           		= $question->id;
				$results['questions'][$i]['description']  		= $question->description;
				$results['questions'][$i]['template_sequence']  = $question->seq;
				$results['questions'][$i]['required']     		= (boolean) $question->required;
				$results['questions'][$i]['type']         		= $question->type;
				$results['questions'][$i]['point']        		= $question->point;
				$results['questions'][$i]['answer']       		= [];
	
				$rst	= $this->loans_service->getAnswer($filter, $question->id);

				foreach ($rst as $iii => $answer) {
					$results['questions'][$i]['answer'][$iii]['id']            = $answer->answer_id;
					$results['questions'][$i]['answer'][$iii]['description']   = $answer->description;
					$results['questions'][$i]['answer'][$iii]['point']         = $answer->point;
				}
			}

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

        return response()->json($results, 200);
    }
}
