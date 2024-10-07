<?php

namespace App\Http\Controllers;

use App\Logs;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $client_id = '';
    public function __construct()
    {
        $this->middleware('auth');
      $this->client_id = config('app.client_id', '');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Carbon::setLocale('id');
        $user = auth()->user();
        // $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        // $logs->write(__FUNCTION__, "START");
        // DB::enableQueryLog();

        if($user && $user->role == 'member'){
            $attr = DB::table('tattr_member as a')
                ->select([
                    'a.birthday',
                    'a.nik',
                    'a.gender',
                    'a.phone',
                    'a.photo as avatar',
                ])
                ->where('a.client_id', $this->client_id)
                ->where('a.id', $user->id)
                ->get();

            // $queries = DB::getQueryLog();
            // for($q = 0; $q < count($queries); $q++) {
            //     $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
            //     $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
            //     $logs->write('SQL', $sql);
            // }
    
            // $logs->write(__FUNCTION__, "STOP\r\n");

            return response()->json([
               'name'               => $user->name,
               'email'              => $user->email,
               'verified'           => ($user->email_verified_at != '') ? true : false,
               'phone'              => $attr[0]->phone ?? '',
               'gender'             => $attr[0]->gender ?? '',
               'birthday'           => $attr[0]->birthday ?? '',
               'nik'                => $attr[0]->nik ?? '',
               'avatar'             => (isset($attr[0]->avatar) && file_exists(public_path('/storage/images/profile/' . $attr[0]->avatar)) ? '/storage/images/profile/' . $attr[0]->avatar : '/storage/images/profile/default.jpg')
            ], 200);
        }

        return response()->json([
            'name'               => '',
            'email'              => '',
            'phone'              => '',
            'gender'             => '',
            'birthday'           => '',
            'nik'                => '',
            'avatar'             => ''
        ], 200);
    }

    public function UpdateProfile(Request $request)
    {
        Carbon::setLocale('id');
        $user = auth()->user();

        $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        $logs->write(__FUNCTION__, 'START');

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'nik' => 'nullable|string|max:20',
            'phone' => 'required|string|max:15',
            'birthday' => 'required|date',
            'gender' => 'required|string|in:L,P',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            DB::enableQueryLog();
            \DB::beginTransaction();

            $emailChanged = $user->email !== $request->email;
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'updated_at' => Carbon::now('Asia/Jakarta'),
            ]);

            if (!empty($request->password)) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            $avatar_name    = "";
            if ($request->hasFile('avatar')) {
                try {
                    $avatar_file    = $request->file('avatar')->getClientOriginalName();
                    $extension      = $request->file('avatar')->getClientOriginalExtension();
                    $avatar_name    = $this->client_id.'-'.$user->id.'.'. $extension;
                    $request->file('avatar')->storeAs('/public/images/profile', $avatar_name);
                } catch (Throwable $th) {
                    $logs->write("ERROR", $th->getMessage());
                }
            }

            $updateData = [
                'nik'           => $request->nik,
                'phone'         => $request->phone,
                'birthday'      => $request->birthday,
                'gender'        => $request->gender,
                'updated_at'    => Carbon::now('Asia/Jakarta')
            ];

            if (!empty($avatar_name)) {
                $updateData['photo'] = $avatar_name;
            }

            $attr = DB::table('tattr_member')
                    ->where('id', $user->id)
                    ->where('client_id', $this->client_id)
                    ->update($updateData);

            if ($emailChanged) {
                $user->sendEmailVerificationNotification();
            }

            \DB::commit();

            // $queries = DB::getQueryLog();
            // for($q = 0; $q < count($queries); $q++) {
            //     $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
            //     $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
            //     $logs->write('SQL', $sql);
            // }

            // $logs->write(__FUNCTION__, "STOP\r\n");
            return response()->json('Update profile successful!.', 201);
        } catch (\Exception $e) {
            $logs->write("ERROR", $e->getMessage());
            \DB::rollBack();

            return response()->json('Update profile failed! Please try again.', 500);
        }
    }
}
