<?php

namespace App\Http\Controllers;

use App\Logs;
use Carbon\Carbon;
use App\Models\Parameter;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
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

    public function getInfoBaca()
    {
        $user = auth()->user();

        // $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        // $logs->write(__FUNCTION__, 'START');
        // DB::enableQueryLog();
		$code = 0;
		$message = "";
		$parameter_baca = 0;

		$parameter = Parameter::where('client_id', $this->client_id)
            ->where('name', 'read_before_game')
            ->first();
		$parameter_baca = $parameter->value;

        $results = DB::table('ttrx_read as a')
			->select([
				DB::raw("count(distinct book_id) as baca")
			])
			->where('a.client_id','=', $this->client_id)
			->where('a.user_id','=', $user->id)
			->whereRaw("CONVERT(a.start_read, DATE) = CONVERT(NOW(), DATE)")
			->first();

        if($results){
            $baca = $results->baca;
        }

		if($baca >= $parameter_baca){
			$code = 1;
		}else{
			$message = "Anda harus membaca minimal ".$parameter_baca." buku hari ini untuk bermain game!";
		}

        // $queries = DB::getQueryLog();
        // for($q = 0; $q < count($queries); $q++) {
        // 	$sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
        // 	$logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
        // 	$logs->write('SQL', $sql);
        // }

        return response()->json([
            'code' => $code,
            'message' => $message
        ], 200);
    }
}
