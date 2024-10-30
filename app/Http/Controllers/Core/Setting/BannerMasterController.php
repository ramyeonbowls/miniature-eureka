<?php

namespace App\Http\Controllers\Core\Setting;

use App\Logs;
use Exception;
use Throwable;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Services\Setting\BannerMasterService;
use App\Http\Requests\Setting\StoreBannerMasterRequest;
use App\Http\Requests\Setting\UpdateBannerMasterRequest;

class BannerMasterController extends Controller
{
    private BannerMasterService $banner_service;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->banner_service = new BannerMasterService();
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

            $results = $this->banner_service->get();

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $queries[$q]['query']);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  IconMenuDeviceRequestStore  $request
     * @return JsonResponse
     */
    public function store(StoreBannerMasterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $result['status'] = 200;
        $result['message'] = '';
        try {
            DB::enableQueryLog();
            
            if ($request->hasFile('file')) {
                try {
                    $banner_file = $request->file('file')->getClientOriginalName();
                    $extension = $request->file('file')->getClientOriginalExtension();
                    $banner_name = explode('.', str_replace(' ', '', $banner_file))[0] . '-' . now('Asia/Jakarta')->format('YmdHis') . '-' . rand(100000, 999999) . '.' . $extension;
                    $request->file('file')->storeAs('/public/images/banner', $banner_name);

                    $validated['file'] = $banner_name;
                } catch (Throwable $th) {
                    $logs->write("ERROR", $th->getMessage());
                }
            }

            $created = $this->banner_service->store((object)$validated);
            if ($created) {
                $logs->write("INFO", "Successfully created");

                $result['status'] = 201;
                $result['message'] = "Data berhasil dibuat.";
            }

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $queries[$q]['query']);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $result['message'] = "Data gagal dibuat.<br>" . $th->getMessage();
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
    public function show(string $id): JsonResponse
    {
        return response()->json($id, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBannerMasterRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(UpdateBannerMasterRequest $request, string $id): JsonResponse
    {
        $validated = $request->validated();

        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $result['status'] = 200;
        $result['message'] = '';
        try {
            DB::enableQueryLog();

            if ($request->hasFile('file')) {
                try {
                    $banner_file = $request->file('file')->getClientOriginalName();
                    $extension = $request->file('file')->getClientOriginalExtension();
                    $banner_name = explode('.', str_replace(' ', '', $banner_file))[0] . '-' . now('Asia/Jakarta')->format('YmdHis') . '-' . rand(100000, 999999) . '.' . $extension;
                    $request->file('file')->storeAs('/public/images/banner', $banner_name);

                    $validated['file'] = $banner_name;
                } catch (Throwable $th) {
                    $logs->write("ERROR", $th->getMessage());
                }
            }

            $updated = $this->banner_service->update((object)$validated, $id);
            if ($updated) {
                $logs->write("INFO", "Successfully updated");

                $result['status'] = 201;
                $result['message'] = "Data berhasil diperbarui.";
            }

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $queries[$q]['query']);
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

            $deleted = $this->banner_service->delete($id);

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $queries[$q]['query']);
            }

            if ($deleted) {
                $result['message'] = 'Data berhasil dihapus';
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $result['message'] = 'Data gagal dihapus.<br>' . $th->getMessage();
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($result['message'], $result['status']);
    }
}
