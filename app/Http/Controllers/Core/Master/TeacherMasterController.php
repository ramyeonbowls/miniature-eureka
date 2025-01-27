<?php

namespace App\Http\Controllers\Core\Master;

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
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Services\Master\TeacherMasterService;
use App\Exports\Master\TeacherMasterTemplateExport;

class TeacherMasterController extends Controller
{
    private TeacherMasterService $Teacher_service;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->Teacher_service = new TeacherMasterService();
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

            $results = $this->Teacher_service->get();

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
            ->editColumn('photo', function ($value) {
                $photo = isset($value->photo) ? public_path('/storage/images/profile/' . $value->photo) : null;
                $photoUrl = $photo && file_exists($photo) ? '/storage/images/profile/' . $value->photo : '/storage/images/profile/default.jpg';
                return $photoUrl;
            })
            ->addIndexColumn()
            ->toJson();
    }

    /**
        * Store a newly created resource in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');
        if($request->has('download') && $request->download == 'tpl') {
            $logs->write(__FUNCTION__, 'Download Tpl');
            return Excel::download(new TeacherMasterTemplateExport(), 'Master_Teacher_Template.xlsx');
		}else{
			$result['status'] = 200;
        	$result['message'] = '';
			$check = true;
			$messages = '';

            if($request->has('type') && $request->type == 'new') {
                $logs->write(__FUNCTION__, 'New');

                try {
                    DB::enableQueryLog();

                    $created = $this->Teacher_service->store($request);
                    if ($created) {
                        $logs->write("INFO", "Successfully updated");

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
                    $logs->write("ERROR", $th->getMessage());

                    $result['message'] = "Data gagal dibuat.<br>" . $th->getMessage();
                }
            }else{
                $logs->write(__FUNCTION__, 'Upload');
                try {
                    DB::beginTransaction();
                    DB::enableQueryLog();
    
                    $spreadsheet         = IOFactory::load($request->file('file'));
                    $Sheetheader         = $spreadsheet->getSheet(0);
                    $H_worksheetTitle    = $Sheetheader->getTitle();
                    $H_highestRow        = $Sheetheader->getHighestRow();
                    $H_worksheetTitle_A  = explode(" ", $H_worksheetTitle);
                    if(strtolower($H_worksheetTitle_A[0])=="teacher"){
                        for ($row = 2; $row <= $H_highestRow; ++ $row) {
                            $name		= trim($Sheetheader->getCellByColumnAndRow(1, $row)->getFormattedValue());
                            $email		= trim($Sheetheader->getCellByColumnAndRow(2, $row)->getFormattedValue());
                            $phone		= trim($Sheetheader->getCellByColumnAndRow(3, $row)->getFormattedValue());
                            $gender		= trim($Sheetheader->getCellByColumnAndRow(4, $row)->getFormattedValue());
                            $birthday	= trim($Sheetheader->getCellByColumnAndRow(5, $row)->getFormattedValue());
                            $nik		= trim($Sheetheader->getCellByColumnAndRow(6, $row)->getFormattedValue());
                            $password	= trim($Sheetheader->getCellByColumnAndRow(7, $row)->getFormattedValue());
    
                            $data = [
                                'name'		=> $name,
                                'email'		=> $email,
                                'phone'		=> $phone,
                                'gender'	=> $gender,
                                'birthday'	=> $birthday,
                                'nik'		=> $nik,
                                'password'	=> $password
                            ];
                        
                            $validator = Validator::make($data, [
                                'name' => ['required', 'string', 'max:255'],
                                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                                'nik' => 'nullable|string|max:20',
                                'phone' => 'required|string|max:15',
                                'birthday' => 'required|date',
                                'gender' => 'required|string|in:L,P',
                                'password' => ['required', 'string', 'min:8'],
                            ]);
    
                            if ($validator->fails()) {
                                $check		= false;
                                $errors = '';
                                foreach ($validator->errors()->all() as $error) {
                                    $errors .= "Errors in row ".$row.": ".$error . "<br>";
                                }
                                $messages	.= $errors;
                            }
    
                            if($check){
                                try {
                                    $created = $this->Teacher_service->store((object)$data);
                                    if (!$created) {
                                        $check		= false;
                                        $messages	= "Data gagal dibuat.";
                                    }
                                }catch (Throwable $e) {
                                    $check		= false;
                                    $messages	= "Data gagal dibuat.";
                                    $logs->write("ERROR", $e->getMessage());
                                }
                            }
    
                        }
                    }else{
                        $check		= false;
                        $messages	= "Salah Template!";
                        $this->logs->write("ERROR", "Wrong Template!");
                    }
    
                    if(!$check){
                        DB::rollBack();
                        $logs->write("Failed", $messages);
                        $result['message']	= $messages;
                    }else {
                        DB::commit();
                        $logs->write("INFO", "Successfully created");
                        $result['status']	= 201;
                        $result['message']	= "Data berhasil dibuat.";
                    }
    
                    $queries = DB::getQueryLog();
                    for($q = 0; $q < count($queries); $q++) {
                        $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                        $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                        $logs->write('SQL', $sql);
                    }
                } catch (Throwable $th) {
                    $logs->write("ERROR", $th->getMessage());
    
                    $result['message'] = "Data gagal dibuat.<br>" . $th->getMessage();
                }
            }
            $logs->write(__FUNCTION__, "STOP\r\n");

            return response()->json($result['message'], $result['status']);
        }
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
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $result['status'] = 200;
        $result['message'] = '';
        try {
            DB::enableQueryLog();

            $updated = $this->Teacher_service->update($request, $id);
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

            $deleted    = $this->Teacher_service->delete($id);

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
            $logs->write("ERROR", $th->getMessage());

            $result['message'] = 'Data gagal dihapus.<br>' . $th->getMessage();
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($result['message'], $result['status']);
    }
}
