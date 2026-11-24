<?php

namespace App\Http\Controllers\Auth;

use App\Logs;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Parameter;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $client_id = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->client_id = config('app.client_id', '');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:15'],
            'birthday' => ['required', 'date_format:Y-m-d'],
            'gender' => ['required', 'string', 'in:L,P'],
            'nik' => ['nullable', 'string', 'max:20'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'flag_approve' => $data['flag_approve'],
            'client_id' => $this->client_id
        ]);
    }

    public function mregist(Request $request)
    {
        $this->validator($request->all())->validate();

        // $logs = new Logs( Arr::last(explode("\\", get_class())) );
        // $logs->write(__FUNCTION__, "START");
        // DB::enableQueryLog();

        $registrasi = Parameter::where('client_id', $this->client_id)
            ->where('name', 'reg_member')
            ->first();

        if(!$registrasi || !$registrasi->value){
            return response()->json('Pendaftaran ditutup, silahkan hubungi petugas perpustakaan.', 500);
        }

        try {
            DB::beginTransaction();
            $flag_approve = Parameter::where('client_id', $this->client_id)
            ->where('name', 'app_reg_member')
            ->first();

            $request['flag_approve'] = $flag_approve && $flag_approve->value ? 'N' : 'Y';
            $request['role'] = 'member';

            $user = $this->create($request->all());

            $attr = DB::table('tattr_member')
                    ->insert([
                        'id'            => $user->id,
                        'client_id'     => $this->client_id,
                        'nik'           => $request->nik,
                        'phone'         => $request->phone,
                        'birthday'      => $request->birthday,
                        'gender'        => $request->gender,
                        'created_at'     => Carbon::now("Asia/Jakarta")
                    ]);

            // $queries = DB::getQueryLog();
            // for($q = 0; $q < count($queries); $q++) {
            //     $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
            //     $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
            //     $logs->write('SQL', $sql);
            // }

            // $logs->write(__FUNCTION__, "STOP\r\n");
            \DB::commit();

        } catch (\Exception $e) {
            // $logs->write('error', $e);
            // $logs->write(__FUNCTION__, "STOP\r\n");
            \DB::rollBack();
            Log::error('Pendaftaran member gagal.', ['exception' => $e]);

            return response()->json('Pendaftaran gagal! Silahkan coba lagi.', 500);
        }

        try {
            event(new Registered($user));
        } catch (\Throwable $e) {
            Log::error('Email verifikasi gagal dikirim.', ['exception' => $e, 'user_id' => $user->id]);

            return response()->json('Pendaftaran berhasil, tetapi email verifikasi gagal dikirim. Silakan masuk untuk meminta pengiriman ulang email verifikasi.', 201);
        }

        return response()->json('Pendaftaran berhasil! Silakan verifikasi email sebelum masuk.', 201);
    }
}
