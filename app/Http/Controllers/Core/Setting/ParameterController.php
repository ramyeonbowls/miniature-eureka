<?php

namespace App\Http\Controllers\Core\Setting;

use App\Logs;
use Exception;
use Throwable;
use Carbon\Carbon;
use App\Models\Parameter;
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

class ParameterController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    protected $client_id = '';
    public function __construct()
    {
        $this->middleware('auth');
        $this->client_id    = config('app.client_id', '');
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
            $results = DB::table('tparameter as a')
                ->select([
                    'a.name',
                    'a.description',
                    'a.value',
                ])
                ->where('a.client_id', $this->client_id)
                ->orderBy('created_at')
                ->get();

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

    public function store(Request $request)
    {
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $result['status']   = 200;
        $result['message']  = '';
        $error              = false;

        try {
            DB::enableQueryLog();
            DB::beginTransaction();

            $validatedData = $request->validate([
                'app_reg_member' => 'required|integer',
                'maks_rent_book' => 'required|integer',
                'reg_member' => 'required|integer',
                'rent_book' => 'required|integer'
            ]);

            foreach ($request->all() as $key => $value) {
                $updated = Parameter::where('name', $key)
                    ->where('client_id', '=', $this->client_id)
                    ->update([
                        'value' => ($value!='') ? $value : 0,
                        'updated_at' => Carbon::now('Asia/Jakarta')
                    ]);

                if (!$updated) {
                    $error = true;
                }
            }

            if($error){
                DB::rollBack();
                $logs->write("INFO", "Failed updated");
                $result['message'] = "Failed updated.<br>";
            }else{
                DB::commit();
                $logs->write("INFO", "Successfully updated");
                $result['status'] = 201;
                $result['message'] = "Successfully updated.";
            }

            $queries = DB::getQueryLog();
            for ($q = 0; $q < count($queries); $q++) {
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $queries[$q]['query']);
            }
        } catch (Exception $e) {
            DB::rollBack();
            $logs->write("ERROR", $th->getMessage());
            $result['message'] = "Failed updated.<br>" . $th->getMessage();
        }

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
        // 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        return response()->json($id, 200);
    }
}
