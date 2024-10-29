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
use App\Services\Master\MemberMasterService;
use App\Exports\Master\MemberMasterTemplateExport;

class MemberMasterController extends Controller
{
    private MemberMasterService $member_service;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->member_service = new MemberMasterService();
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

            $results = $this->member_service->get();

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
            return Excel::download(new MemberMasterTemplateExport(), 'Master_Member_Template.xlsx');
         }else{
			$result['status'] = 200;
        	$result['message'] = '';
			$check = true;
			$messages = '';

            try {
				DB::beginTransaction();
                DB::enableQueryLog();

				$spreadsheet         = IOFactory::load($request->file('file'));
				$Sheetheader         = $spreadsheet->getSheet(0);
				$H_worksheetTitle    = $Sheetheader->getTitle();
				$H_highestRow        = $Sheetheader->getHighestRow();
				$H_worksheetTitle_A  = explode(" ", $H_worksheetTitle);
				if(strtolower($H_worksheetTitle_A[0])=="member"){
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
								$created = $this->member_service->store((object)$data);
								if (!$created) {
									$check		= false;
									$messages	= "Failed created.";
								}
							}catch (Throwable $e) {
								$check		= false;
								$messages	= "Failed created.";
								$logs->write("ERROR", $e->getMessage());
							}
						}

					}
				}else{
					$check		= false;
					$messages	= "Wrong Template!";
					$this->logs->write("ERROR", "Wrong Template!");
				}

				if(!$check){
					DB::rollBack();
					$logs->write("Failed", $result['message']);
					$result['message']	= $messages;
				}else {
					DB::commit();
					$logs->write("INFO", "Successfully created");
					$result['status']	= 201;
					$result['message']	= "Successfully created.";
				}

                $queries = DB::getQueryLog();
				for($q = 0; $q < count($queries); $q++) {
					$sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
					$logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
					$logs->write('SQL', $sql);
				}
            } catch (Throwable $th) {
                $logs->write("ERROR", $th->getMessage());

                $result['message'] = "Failed created.<br>" . $th->getMessage();
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
     * @param UpdateMemberMasterRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(UpdateMemberMasterRequest $request, string $id): JsonResponse
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
                    $Member_file = $request->file('file')->getClientOriginalName();
                    $extension = $request->file('file')->getClientOriginalExtension();
                    $Member_name = explode('.', str_replace(' ', '', $Member_file))[0] . '-' . now('Asia/Jakarta')->format('YmdHis') . '-' . rand(100000, 999999) . '.' . $extension;
                    $request->file('file')->storeAs('/public/images/Member', $Member_name);

                    $validated['file'] = $Member_name;
                } catch (Throwable $th) {
                    $logs->write("ERROR", $th->getMessage());
                }
            }

            $updated = $this->member_service->update((object)$validated, $id);
            if ($updated) {
                $logs->write("INFO", "Successfully updated");

                $result['status'] = 201;
                $result['message'] = "Successfully updated.";
            }

            $queries = DB::getQueryLog();
            for($q = 0; $q < count($queries); $q++) {
                $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $sql);
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $result['message'] = "Failed updated.<br>" . $th->getMessage();
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

            $check      = $this->member_service->check($id);
            $dibaca     = $check[0]->total ?? 0;

            if($dibaca > 0){
                $result['message'] = 'Member tidak bisa dihapus, karna sudah pernah baca buku';

                return response()->json($result['message'], $result['status']);
            }

            $deleted    = $this->member_service->delete($id);

            $queries = DB::getQueryLog();
            for($q = 0; $q < count($queries); $q++) {
                $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
                $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
                $logs->write('SQL', $sql);
            }

            if ($check) {
                $result['message'] = 'Successfully deleted';
            }
        } catch (Throwable $th) {
            $logs->write("ERROR", $th->getMessage());

            $result['message'] = 'Failed delete.<br>' . $th->getMessage();
        }
        $logs->write(__FUNCTION__, "STOP\r\n");

        return response()->json($result['message'], $result['status']);
    }
}
