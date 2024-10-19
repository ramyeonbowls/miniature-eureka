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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Setting\UpdateProfileMasterRequest;

class ProfileMasterController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    protected $client_id = '';
    protected $app_url = '';
    public function __construct()
    {
        $this->middleware('auth');
        $this->client_id    = config('app.client_id', '');
        $this->app_url      = config('app.url', '');
    }


    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, "START");
        DB::enableQueryLog();

        $results = [];
        if($user && $user->role == 'admin'){
            $results = DB::table('tclient as a')
                ->select([
                    'a.*',
                    'b.provinsi_name',
                    'c.kabupaten_name',
                    'd.kecamatan_name',
                    'e.kelurahan_name',
                    DB::raw("'".$this->app_url."offline-visitor' as app_url")
                ])
                ->join('tprovinsi as b', 'a.provinsi_id', '=', 'b.provinsi_id')
                ->join('tkabupaten as c', 'a.kabupaten_id', '=', 'c.kabupaten_id')
                ->join('tkecamatan as d', 'a.kecamatan_id', '=', 'd.kecamatan_id')
                ->join('tkelurahan as e', 'a.kelurahan_id', '=', 'e.kelurahan_id')
                ->where('a.client_id', $this->client_id)
                ->first();

            $queries = DB::getQueryLog();
            for($q = 0; $q < count($queries); $q++) {
                $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $sql);
            }
    
            $logs->write(__FUNCTION__, "STOP\r\n");

            return response()->json($results, 200);
        }

        return response()->json($results, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UpdateProfileMasterRequest  $request
     * @return JsonResponse
     */
    public function store(UpdateProfileMasterRequest $request): JsonResponse
    {
        $user = auth()->user();
        $validated = $request->validated();

        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $result['status'] = 200;
        $result['message'] = '';
        try {
            DB::enableQueryLog();
            
            if ($request->hasFile('logo')) {
                try {
                    $extension = $request->file('logo')->getClientOriginalExtension();
                    $logo_name = 'logo.' . $extension;

                    $request->file('logo')->move(public_path('images/logo'), $logo_name);
                } catch (Throwable $th) {
                    $logs->write("ERROR", $th->getMessage());
                }
            }
            
            if ($request->hasFile('logo_small')) {
                try {
                    $extension          = $request->file('logo_small')->getClientOriginalExtension();
                    $logo_small_name    = 'logo_small.' . $extension;
                    $favicon            = 'favicon.' . $extension;

                    $request->file('logo_small')->move(public_path('images/logo'), $logo_small_name);
                    $request->file('logo_small')->move(public_path('images/logo'), $logo_small_name);
                } catch (Throwable $th) {
                    $logs->write("ERROR", $th->getMessage());
                }
            }

            $data = (object)$validated;

            $updateData = [
                'application_name'      => $request->application_name,
                'address'               => $request->address,
                'npwp'                  => $request->npwp,
                'administrator_name'    => $request->administrator_name,
                'administrator_phone'   => $request->administrator_phone,
                'updated_at'            => Carbon::now('Asia/Jakarta')
            ];

            if ($request->has('password')) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            $created = DB::table('tclient')
                    ->where('client_id', $this->client_id)
                    ->update($updateData);
   
            if ($created) {
                $logs->write("INFO", "Successfully created");

                $result['status'] = 201;
                $result['message'] = "Successfully created.";
            }

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $queries[$q]['query']);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $result['message'] = "Failed created.<br>" . $th->getMessage();
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($result['message'], $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');

        if (request()->has('param') && request()->param != '') {
            switch (request()->param) {
                case 'provinsi-mst':
                    DB::enableQueryLog();

                    $provinsi = DB::table('tprovinsi as a')->sharedLock()
                        ->select(
                            'a.provinsi_id as id',
                            'a.provinsi_name as name'
                        )
                        ->get();

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results = [];
                    if($provinsi) {
                        $results = $provinsi->map(function($value, $key) {
                            return [
                                'id' => $value->id,
                                'name' => $value->name
                            ];
                        });
                    }

                    return response()->json($results, 200);
                break;

                case 'kabupaten-mst':
                    DB::enableQueryLog();

                    $provinsi = request()->provinsi ?? '';
                    $kabupaten = DB::table('tkabupaten as a')->sharedLock()
                        ->select(
                            'a.kabupaten_id as id',
                            'a.kabupaten_name as name'
                        )
                        ->when(isset($provinsi) && $provinsi != '', function($query) use ($provinsi) {
                            $query->where('a.provinsi_id', $provinsi);
                        })
                        ->get();

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results = [];
                    if($kabupaten) {
                        $results = $kabupaten->map(function($value, $key) {
                            return [
                                'id' => $value->id,
                                'name' => $value->name
                            ];
                        });
                    }

                    return response()->json($results, 200);
                break;

                case 'kecamatan-mst':
                    DB::enableQueryLog();

                    $provinsi = request()->provinsi ?? '';
                    $kabupaten = request()->kabupaten ?? '';
                    $kecamatan = DB::table('tkecamatan as a')->sharedLock()
                        ->select(
                            'a.kecamatan_id as id',
                            'a.kecamatan_name as name'
                        )
                        ->when(isset($provinsi) && $provinsi != '', function($query) use ($provinsi) {
                            $query->where('a.provinsi_id', $provinsi);
                        })
                        ->when(isset($kabupaten) && $kabupaten != '', function($query) use ($kabupaten) {
                            $query->where('a.kabupaten_id', $kabupaten);
                        })
                        ->get();

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results = [];
                    if($kecamatan) {
                        $results = $kecamatan->map(function($value, $key) {
                            return [
                                'id' => $value->id,
                                'name' => $value->name
                            ];
                        });
                    }

                    return response()->json($results, 200);
                break;

                case 'kelurahan-mst':
                    DB::enableQueryLog();

                    $provinsi = request()->provinsi ?? '';
                    $kabupaten = request()->kabupaten ?? '';
                    $kecamatan = request()->kecamatan ?? '';
                    $kelurahan = DB::table('tkelurahan as a')->sharedLock()
                        ->select(
                            'a.kelurahan_id as id',
                            'a.kelurahan_name as name'
                        )
                        ->when(isset($provinsi) && $provinsi != '', function($query) use ($provinsi) {
                            $query->where('a.provinsi_id', $provinsi);
                        })
                        ->when(isset($kabupaten) && $kabupaten != '', function($query) use ($kabupaten) {
                            $query->where('a.kabupaten_id', $kabupaten);
                        })
                        ->when(isset($kecamatan) && $kecamatan != '', function($query) use ($kecamatan) {
                            $query->where('a.kecamatan_id', $kecamatan);
                        })
                        ->get();

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results = [];
                    if($kelurahan) {
                        $results = $kelurahan->map(function($value, $key) {
                            return [
                                'id' => $value->id,
                                'name' => $value->name
                            ];
                        });
                    }

                    return response()->json($results, 200);
                break;

                case 'kategori-mst':
                    DB::enableQueryLog();

                    $ketegori = DB::table('tbook_category as a')->sharedLock()
                        ->select(
                            'a.id as id',
                            'a.description as name'
                        )
                        ->get();

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results = [];
                    if($ketegori) {
                        $results = $ketegori->map(function($value, $key) {
                            return [
                                'id' => $value->id,
                                'name' => $value->name
                            ];
                        });
                    }

                    return response()->json($results, 200);
                break;

                default:
                    return response()->json(request()->param, 200);
                break;
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        return response()->json($request, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        return response()->json($id, 200);
    }

    public function exportPDF(Request $request)
    {
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        return view('pdf.agreement_letter');

        $logs->write(__FUNCTION__, "STOP\r\n");
    }
}
