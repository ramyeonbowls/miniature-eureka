<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use UAParser\Parser;

class TitikBacaController extends Controller
{
    protected $client_id = '';
    public function __construct()
    {
        $this->client_id = config('app.client_id', '');
    }

    public function index(Request $request)
    {
        $idt = $request->input('idt');
        $titikbaca = DB::table('ttitik_baca as a')
            ->select([
                'a.name',
            ])
            ->where('a.client_id', $this->client_id)
            ->where('a.id', $idt)
            ->first();

        if (!$titikbaca) {
            abort(404, 'Titik Baca tidak ditemukan.');
        }

        return response()->json([
            'code' => '1',
            'message' => 'Titik Baca ditemukan.',
            'name' => $titikbaca->name
        ]);
    }

    public function loginByQrCode(Request $request)
    {
        $id     = $request->input('id');
        $device = $request->header('User-Agent') ?? 'unknown';
        $ip     = $request->ip();

        $email  = DB::table('user_by_titikbaca')
            ->select([
                'email',
            ])
            ->where('client_id', $this->client_id)
            ->where('id', $id)
            ->first();

        $titikbaca = DB::table('ttitik_baca as a')
            ->select([
                'a.name',
            ])
            ->where('a.client_id', $this->client_id)
            ->where('a.id', $id)
            ->first();
        
        if ($email) {
            $user = DB::table('users')->where('email', $email->email)->first();

            if (!$user) {
                return response()->json(['error' => 'User tidak ada'], 404);
            }

            if (!Auth::check()) {
                Auth::loginUsingId($user->id);
            }
            $uuid = (string) Str::uuid();

            $parser = Parser::create();
            $result = $parser->parse(request()->header('User-Agent'));

            DB::table('login_by_qr')->insert([
                'client_id'     => $this->client_id,
                'titikbaca_id'  => $id,
                'uuid'          => $uuid,
                'device'        => $result->device->brand.'|'. $result->device->model.'|'.$result->os->family.' '.$result->os->toVersion().'|'.$result->ua->family.'|'.$ip,
                'created_at'    => Carbon::now(),
            ]);

            return response()->json(['message' => 'Login berhasil', 'uuid' => $uuid, 'place' => $titikbaca->name]);
        }

        return response()->json(['error' => 'Titik baca tidak ditemukan'], 404);
    }
}
