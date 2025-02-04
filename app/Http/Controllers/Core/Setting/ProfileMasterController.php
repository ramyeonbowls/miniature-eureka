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
        $this->client_id    	= config('app.client_id', '');
        $this->app_url      	= config('app.url', '');
        $this->app_url_offline	= config('app.url_offline', '');
        $this->db_platform      = config('app.db_platform', '').'.';
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
                    DB::raw("'".$this->app_url."' as app_url"),
                    DB::raw("'".$this->app_url_offline."' as app_url_offline")
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

            $change_logo = 'N';
            if ($request->hasFile('logo')) {
                try {
                    $extension = $request->file('logo')->getClientOriginalExtension();
                    $logo_name = 'logo.' . $extension;
                    $change_logo = 'Y';

                    $request->file('logo')->move(public_path('images/logo'), $logo_name);
                } catch (Throwable $th) {
                    $logs->write("ERROR", $th->getMessage());
                }
            }
            
            if ($request->hasFile('logo_small')) {
                try {
                    $extension          = $request->file('logo_small')->getClientOriginalExtension();
                    $logo_small_name    = 'logo_small.' . $extension;
                    $favicon_name       = 'favicon.' . $extension;
                    $change_logo        = 'Y';

                    $logoSmallPath		= $request->file('logo_small')->move(public_path('images/logo'), $logo_small_name);
                    
					// Resize the favicon image
					list($width, $height) = getimagesize($logoSmallPath);
					$newWidth = 200;
					$newHeight = 200;
			
					// Create a new blank image with the new dimensions
					$resizedImage = imagecreatetruecolor($newWidth, $newHeight);
			
					// Load the original image based on its type
					switch (strtolower($extension)) {
						case 'png':
							$source = imagecreatefrompng(public_path('images/logo/' . $logo_small_name));
							imagealphablending($resizedImage, false);
							imagesavealpha($resizedImage, true);
							break;
						default:
							throw new Exception('Unsupported image format.');
					}
			
					// Resize and save the favicon image
					imagecopyresampled($resizedImage, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
					$faviconPath = public_path('storage/images/logo/' . $favicon_name);
			
					switch (strtolower($extension)) {
						case 'png':
							imagepng($resizedImage, $faviconPath);
							break;
					}
			
					// Free memory
					imagedestroy($resizedImage);
					imagedestroy($source);
                } catch (Throwable $th) {
                    $logs->write("ERROR", $th->getMessage());
                }
            }

            $data = (object)$validated;

            $insertedData = [
                'client_id'             => $this->client_id,
                'instansi_name'         => ($request->instansi_name == 'null') ? null : $request->instansi_name,
                'application_name'      => ($request->application_name == 'null') ? null : $request->application_name,
                'address'               => ($request->address == 'null') ? null : $request->address,
                'country_id'            => ($request->country_id == 'null') ? null : $request->country_id,
                'provinsi_id'           => ($request->provinsi_id == 'null') ? null : $request->provinsi_id,
                'kabupaten_id'          => ($request->kabupaten_id == 'null') ? null : $request->kabupaten_id,
                'kecamatan_id'          => ($request->kecamatan_id == 'null') ? null : $request->kecamatan_id,
                'kelurahan_id'          => ($request->kelurahan_id == 'null') ? null : $request->kelurahan_id,
                'kodepos'               => ($request->kodepos == 'null') ? null : $request->kodepos,
                'npwp'                  => ($request->npwp == 'null') ? null : $request->npwp,
                'pers_responsible'      => ($request->pers_responsible == 'null') ? null : $request->pers_responsible,
                'pos_pers_responsible'  => ($request->pos_pers_responsible == 'null') ? null : $request->pos_pers_responsible,
                'mou_sign_name'         => ($request->mou_sign_name == 'null') ? null : $request->mou_sign_name,
                'pos_sign_name'         => ($request->pos_sign_name == 'null') ? null : $request->pos_sign_name,
                'administrator_name'    => ($request->administrator_name == 'null') ? null : $request->administrator_name,
                'administrator_phone'   => ($request->administrator_phone == 'null') ? null : $request->administrator_phone,
                'logo'                  => ($request->logo == 'null') ? null : $request->logo,
                'logo_small'            => ($request->logo_small == 'null') ? null : $request->logo_small,
                'company_id'            => ($request->company_id == 'null') ? null : $request->company_id,
                'web_add'               => ($request->web_add == 'null') ? null : $request->web_add,
                'agreement'             => ($request->agreement == 'null') ? null : $request->agreement,
                'client_category'       => ($request->client_category == 'null') ? null : $request->client_category,
                'client_level'          => ($request->client_level == 'null') ? null : $request->client_level,
                'flag_appr'             => 'N',
                'created_at'            => Carbon::now('Asia/Jakarta')
            ];

            if ($request->has('password')) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            $existingData = DB::table('tclient')
                ->where('client_id', $this->client_id)
                ->first();

            if ($existingData) {
                $existingDataArray = (array) $existingData;
                $compareData = $insertedData;
                unset($compareData['created_at'], $compareData['flag_appr']);
                unset($existingDataArray['created_at'], $existingDataArray['updated_at'], $existingDataArray['flag_appr']);

                // Sort both arrays by keys
                ksort($compareData);
                ksort($existingDataArray);
                $differences = array_diff_assoc($compareData, $existingDataArray);
                $logs->write("INFO diffrence", print_r($differences, true));
                $logs->write("INFO change", print_r($compareData, true));
                $logs->write("INFO data", print_r($existingDataArray, true));

                if (!empty($differences)) {
                    $created = DB::table($this->db_platform.'tclient_temp')->insert($insertedData);

                    if ($created) {
                        $logs->write("INFO", "Request update Successfully");

                        $result['status'] = 201;
                        $result['message'] = "Permohonan perubahan data berhasil.";
                    }
                }else{
                    if($change_logo == 'Y'){
                        $logs->write("INFO", "Successfully Change Logo");
    
                        $result['status'] = 201;
                        $result['message'] = "Perubahan logo berhasil.";
                    }else{
                        $logs->write("INFO", "No changes detected.");
    
                        $result['status'] = 201;
                        $result['message'] = "Tidak ada perubahan data.";
                    }
                }

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
                case 'change-request':
                    DB::enableQueryLog();

                    $change_request = DB::table($this->db_platform.'tclient_temp as a')
                        ->select(
                            DB::raw("case when a.flag_appr = 'N' then 'Y' else 'N' end as change_request")
                        )
                        ->where('flag_appr', 'N')
                        ->orderBy('created_at', 'DESC')
                        ->first();

                    $queries = DB::getQueryLog();
                    for ($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }

                    $results = ($change_request) ? $change_request : ['change_request' => 'N'];

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
