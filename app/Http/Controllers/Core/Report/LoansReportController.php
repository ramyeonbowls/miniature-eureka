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
use App\Exports\Report\LoansReportExport;
use App\Services\Report\LoansReportService;
use Yajra\DataTables\Facades\DataTables;

class LoansReportController extends Controller
{
    private LoansReportService $loans_service;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->loans_service = new LoansReportService();
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

        $results = [];
        try {
            DB::enableQueryLog();

            $filter['PROVINSI']     = $request->PROVINSI ?? '';
            $filter['KABUPATEN']    = $request->KABUPATEN ?? '';
            $filter['WL']           = $request->WL ?? '';
            $filter['START_DATE']   = $request->START_DATE ?? '';
            $filter['END_DATE']     = $request->END_DATE ?? '';
            $filter['STATUS']       = $request->STATUS ?? '';

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
            $filter['STATUS']       = $request->STATUS ?? '';

            $this->loans_service->get($filter)->map(function($value, $i) use (&$results) {
                $results[$i]['wl_name']         = $value->wl_name;
                $results[$i]['provinsi_name']   = $value->provinsi_name;
                $results[$i]['kabupaten_name']  = $value->kabupaten_name;
    			$results[$i]['name']            = $value->name;
    			$results[$i]['start_date']      = $value->start_date;
    			$results[$i]['title']           = $value->title;
    			$results[$i]['end_date']        = $value->end_date;
    			$results[$i]['flag_end']        = ($value->flag_end=='Y') ? 'Dikembalikan' : "Dipinjam";
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

        return Excel::download(new LoansReportExport($results), 'Laporan_Baca_Buku.xlsx');
    }
}
