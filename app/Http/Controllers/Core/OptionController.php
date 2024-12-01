<?php

namespace App\Http\Controllers\Core;

use App\Logs;
use App\Libraries;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OptionController extends Controller
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
        $this->client_id	= config('app.client_id', '');
        $this->isDinas		= Libraries::isDinas();
    }

    public function option(Request $request)
    {
        switch ($request->opt) {
            case 'Country':
                return response()->json($this->Country(), 200);
            break;

            case 'Provinsi':
                return response()->json($this->Provinsi(), 200);
            break;

            case 'Kabupaten':
                return response()->json($this->Kabupaten($request), 200);
            break;

            case 'Kecamatan':
                return response()->json($this->Kecamatan($request), 200);
            break;

            case 'Kelurahan':
                return response()->json($this->Kelurahan($request), 200);
            break;

            case 'WhiteLabel':
                return response()->json($this->WhiteLabel($request), 200);
            break;
        }
    }

    public function Country()
    {
        // $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        // $logs->write(__FUNCTION__, "START");
        // DB::enableQueryLog();

        $results = [];
        $sql = DB::table('tcountry as a')
                ->select([
                    'a.country_id',
                    'a.country_name'
                ]);

        $results = $sql->get();

        // $queries = DB::getQueryLog();
        // for($q = 0; $q < count($queries); $q++) {
        //     $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
        //     $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
        //     $logs->write('SQL', $sql);
        // }

        // $logs->write(__FUNCTION__, "STOP\r\n");
        
        return ($results);
    }
    
    public function Provinsi()
    {
        // $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        // $logs->write(__FUNCTION__, "START");
        // DB::enableQueryLog();

        $results = [];
        $sql = DB::table('tprovinsi as a')
            ->select([
                'a.provinsi_id',
                'a.provinsi_name'
            ]);

        if($this->isDinas['status']){
            if($this->isDinas['level'] != '6001'){
                $sql->where('a.provinsi_id', $this->isDinas['provinsi']);
            }
        }else{
            $sql->where('a.provinsi_id', $this->isDinas['provinsi']);
        }

        $results = $sql->get();

        // $queries = DB::getQueryLog();
        // for($q = 0; $q < count($queries); $q++) {
        //     $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
        //     $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
        //     $logs->write('SQL', $sql);
        // }

        // $logs->write(__FUNCTION__, "STOP\r\n");
        
        return ($results);
    }
    
    public function Kabupaten(Request $request)
    {
        // $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        // $logs->write(__FUNCTION__, "START");
        // DB::enableQueryLog();

        $results = [];
        $sql = DB::table('tkabupaten as a')
                ->select([
                    'a.kabupaten_id',
                    'a.kabupaten_name'
                ]);

        if($this->isDinas['status']){
            $sql->where('a.provinsi_id', $this->isDinas['provinsi']);
            if($this->isDinas['level'] == '6003'){
                $sql->where('a.kabupaten_id', $this->isDinas['kabupaten']);
            }
        }else{
            $sql->where('a.provinsi_id', $this->isDinas['provinsi']);
            $sql->where('a.kabupaten_id', $this->isDinas['kabupaten']);
        }

        $results = $sql->get();

        // $queries = DB::getQueryLog();
        // for($q = 0; $q < count($queries); $q++) {
        //     $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
        //     $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
        //     $logs->write('SQL', $sql);
        // }

        // $logs->write(__FUNCTION__, "STOP\r\n");
        
        return ($results);
    }
    
    public function Kecamatan(Request $request)
    {
        // $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        // $logs->write(__FUNCTION__, "START");
        // DB::enableQueryLog();

        $results = [];
        $sql = DB::table('tkecamatan as a')
                ->select([
                    'a.kecamatan_id',
                    'a.kecamatan_name'
                ])
                ->where('a.provinsi_id', $request->PROVINSI)
                ->where('a.kabupaten_id', $request->KABUPATEN);

        $results = $sql->get();

        // $queries = DB::getQueryLog();
        // for($q = 0; $q < count($queries); $q++) {
        //     $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
        //     $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
        //     $logs->write('SQL', $sql);
        // }

        // $logs->write(__FUNCTION__, "STOP\r\n");
        
        return ($results);
    }
    
    public function Kelurahan(Request $request)
    {
        // $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        // $logs->write(__FUNCTION__, "START");
        // DB::enableQueryLog();

        $results = [];
        $sql = DB::table('tkelurahan as a')
                ->select([
                    'a.kelurahan_id',
                    'a.kelurahan_name'
                ])
                ->where('a.provinsi_id', $request->PROVINSI)
                ->where('a.kabupaten_id', $request->KABUPATEN)
                ->where('a.kecamatan_id', $request->KECAMATAN);

        $results = $sql->get();

        // $queries = DB::getQueryLog();
        // for($q = 0; $q < count($queries); $q++) {
        //     $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
        //     $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
        //     $logs->write('SQL', $sql);
        // }

        // $logs->write(__FUNCTION__, "STOP\r\n");
        
        return ($results);
    }

    public function WhiteLabel(Request $request)
    {
        // $logs = new Logs(Arr::last(explode("\\", get_class())) . 'Log');
        // $logs->write(__FUNCTION__, "START");
        // DB::enableQueryLog();

        $results = [];
        $sql = DB::table('tclient as a')
                ->select([
                    'a.instansi_name'
                ])
                ->where('a.provinsi_id', $request->PROVINSI)
                ->where('a.kabupaten_id', $request->KABUPATEN)
                ->distinct();

				if(!$this->isDinas['status']){
					$sql->where('a.client_id', $this->client_id);
				}

        $results = $sql->get();

        // $queries = DB::getQueryLog();
        // for($q = 0; $q < count($queries); $q++) {
        //     $sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
        //     $logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
        //     $logs->write('SQL', $sql);
        // }

        // $logs->write(__FUNCTION__, "STOP\r\n");
        
        return ($results);
    }
}
