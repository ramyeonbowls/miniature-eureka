<?php

namespace App\Http\Controllers;

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
use App\Http\Requests\Register\StoreFormRegisterRequest;

class FormRegisterController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json($request, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreFormRegisterRequest  $request
     * @return JsonResponse
     */
    public function store(StoreFormRegisterRequest $request): JsonResponse
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
                    $banner_name = now('Asia/Jakarta')->format('YmdHis') . '-' . rand(100000, 999999) . '-' . $banner_file;

                    $request->file('file')->storeAs('/public/logo', $banner_name);

                    $validated['file'] = '/storage/logo/'. $banner_name;
                } catch (Throwable $th) {
                    $logs->write("ERROR", $th->getMessage());
                }
            }

            $data = (object)$validated;
            $data->type = (bool)$data->supplier && (bool)$data->distributor ? 3 : ( (bool)$data->distributor ? 2 : 1 );

            $header_id = Str::uuid();

            $created = DB::table('tsupplier_distributor')
                ->updateOrInsert([
                    'id' => $header_id,
                ], [
                    'type' => $data->type ?? '',
                    'nama_perusahaan' => $data->nama_perusahaan ?? '',
                    'email_perusahaan' => $data->email_perusahaan ?? '',
                    'password' => $data->password ?? '',
                    'password_confirmation' => $data->password_confirmation ?? '',
                    'negara' => $data->negara ?? '',
                    'provinsi' => $data->provinsi ?? '',
                    'kabupaten' => $data->kabupaten ?? '',
                    'kecamatan' => $data->kecamatan ?? '',
                    'keluarahan' => $data->keluarahan ?? '',
                    'kode_pos' => $data->kode_pos ?? '',
                    'alamat' => $data->alamat ?? '',
                    'telepon' => $data->telepon ?? '',
                    'handphone' => $data->handphone ?? '',
                    'pimpinan' => $data->pimpinan ?? '',
                    'jabatan' => $data->jabatan ?? '',
                    'hpimpinan' => $data->hpimpinan ?? '',
                    'pic' => $data->pic ?? '',
                    'hpic' => $data->hpic ?? '',
                    'file' => $data->file ?? '',
                    'created_at' => Carbon::now("Asia/Jakarta"),
                    'created_by' => $data->email_perusahaan ?? '',
                    'updated_at' => Carbon::now("Asia/Jakarta"),
                    'updated_by' => $data->email_perusahaan ?? '',
                ]);

            $data_imprint = json_decode($data->imprint);
            foreach ($data_imprint as $i => $value) {
                $imprint = DB::table('tsupplier_imprint')
                    ->updateOrInsert([
                        'sid' => $header_id,
                        'id' => Str::uuid(),
                    ], [
                        'name' => $value->nama,
                        'created_at' => Carbon::now("Asia/Jakarta"),
                        'created_by' => $data->email_perusahaan,
                        'updated_at' => Carbon::now("Asia/Jakarta"),
                        'updated_by' => $data->email_perusahaan,
                    ]);
            }

            $data_kuasa = json_decode($data->kuasa);
            foreach ($data_kuasa as $i => $value) {
                $kuasa = DB::table('tsupplier_kuasa')
                    ->updateOrInsert([
                        'sid' => $header_id,
                        'id' => Str::uuid(),
                    ], [
                        'name' => $value->nama,
                        'created_at' => Carbon::now("Asia/Jakarta"),
                        'created_by' => $data->email_perusahaan,
                        'updated_at' => Carbon::now("Asia/Jakarta"),
                        'updated_by' => $data->email_perusahaan,
                    ]);
            }

            $data_kategori = json_decode($data->kategori);
            foreach ($data_kategori as $i => $value) {
                $kategori = DB::table('tsupplier_book_category')
                    ->updateOrInsert([
                        'sid' => $header_id,
                        'category' => $value->id,
                    ], [
                        'created_at' => Carbon::now("Asia/Jakarta"),
                        'created_by' => $data->email_perusahaan,
                        'updated_at' => Carbon::now("Asia/Jakarta"),
                        'updated_by' => $data->email_perusahaan,
                    ]);
            }

            $data_rekening = json_decode($data->rekening);
            foreach ($data_rekening as $i => $value) {
                $kuasa = DB::table('trekening_bank')
                    ->updateOrInsert([
                        'sid' => $header_id,
                        'id' => Str::uuid(),
                    ], [
                        'npwp' => $value->npwp ?? '',
                        'norek' => $value->norek ?? '',
                        'bank' => $value->bank ?? '',
                        'nama' => $value->nama ?? '',
                        'kota' => $value->kota ?? '',
                        'created_at' => Carbon::now("Asia/Jakarta"),
                        'created_by' => $data->email_perusahaan,
                        'updated_at' => Carbon::now("Asia/Jakarta"),
                        'updated_by' => $data->email_perusahaan,
                    ]);
            }
                
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
}
