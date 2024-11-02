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
use Illuminate\Support\Facades\Validator;

class ProfileTeacherMasterController extends Controller
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
        if($user && $user->role == 'teacher'){
            $results = DB::table('users as a')
                ->select([
                    'a.id',
                    'a.email',
                    'a.name',
					'phone',
					'gender',
					'birthday',
					'nik'
                ])
				->join('tattr_member as b', function($join) {
					$join->on('a.id', '=', 'b.id');
				})
                ->where('a.client_id', $this->client_id)
                ->where('a.id', $user->id)
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
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $user = auth()->user();
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $result['status'] = 200;
        $result['message'] = '';
        try {
            DB::enableQueryLog();

			$validator = Validator::make($request->all(), [
				'name' => ['required', 'string', 'max:255'],
				'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
				'nik' => 'nullable|string|max:20',
				'phone' => 'required|string|max:15',
				'birthday' => 'required|date',
				'gender' => 'required|string|in:L,P',
				'password' => ['required', 'string', 'min:8']
			]);
	
			if ($validator->fails()) {
				return response()->json([
					'errors' => $validator->errors()
				], 400);
			}

            if ($request->has('password')) {
                if($user->update(['password' => Hash::make($request->password)])){
					$logs->write("INFO", "Berhasil Update Data.");

					$result['status'] = 201;
					$result['message'] = "Berhasil Update Data.";
				}
            }else{
				$result['status'] = 201;
				$result['message'] = "Tidak Ada Data Yang Di Update.";
			}

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $queries[$q]['query']);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $result['message'] = "Gagal Update Data.<br>" . $th->getMessage();
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
