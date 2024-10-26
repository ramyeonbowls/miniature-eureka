<?php

namespace App\Console\Commands;

use App\Logs;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AutoUpdateTrx extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ginesia:update-trx {BLOCK=READ} {--allclients} {--debug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for update flag transaction with parameters {BLOCK=which transaction to update} {--allclients=whether all clients or just this client} {--debug=print query to logs}';

    /**
     * Execute the console command.
     */
    public function handle()
    {
		$client_id			= config('app.client_id', '');
        $job_info       	= pathinfo(__FILE__); 
        $nama_jobs			= $job_info['filename'];
		$now				= Carbon::now('Asia/Jakarta');
		$filter_block   	= ($this->argument('BLOCK')) ? $this->argument('BLOCK') : 'READ';
		$this->debug		= $this->option('debug') ?? 0;
		$this->allclients	= $this->option('allclients') ?? 0;

		$logs = new Logs(($this->allclients ? '' : $client_id.'_' ).$nama_jobs.'_'.$filter_block);
        $logs->write('START', '');

		switch ($filter_block) {
            case 'READ':
                goto READ;
                break;

            case 'RENT':
                goto RENT;
                break;
        }

        if (!($filter_block=='' || $filter_block=='ALLBLOCK')) goto SELESAI;

		READ:
        /* READ */
            $SECTIONNAME = "READ";
            $READ_H_CountSuccess = $READ_H_CountFailed = 0;
			if($this->debug) DB::enableQueryLog();

			$query = DB::table('ttrx_read as a')
				->select([
					'a.id',
					'a.client_id',
					'a.user_id',
					'a.book_id',
					'a.start_read',
					'a.end_read'
				])
				->when(!$this->allclients, function ($query) use ($client_id) {
					return $query->where('a.client_id', $client_id);
				})
				->where('a.flag_end', 'N')
				->where('end_read', '<=', Carbon::now('Asia/Jakarta')->subMinutes(30))
				->get();

            try {
				$this->line("BEGIN => ". $SECTIONNAME);

				$row = count($query);
				$logs->write("Data", "[".$row."]");

                if ($row > 0) {
					$this->line("Found ". $row." Data" );

					foreach ($query as $value) {
						$update	= DB::table('ttrx_read')
						->where('id', $value->id)
						->where('client_id', $value->client_id)
						->where('user_id', $value->user_id)
						->where('book_id', $value->book_id)
						->update([
							'flag_end'  => 'Y',
							'updated_at' => $now
						]);
					}
                }else{
                    $this->line("No Data");  
                }

                $this->line("END => ". $SECTIONNAME."\r\n" );
            } catch (\PDOException $e_H) {
                $sqlState   = $e_H->errorInfo[0];
                $errCode    = $e_H->errorInfo[1];
                $errMessage = $e_H->errorInfo[2];

				$logs->write($SECTIONNAME, "ERROR ". $sqlState. " => ". $errMessage. "\n");
            }

			if($this->debug){
				$queries = DB::getQueryLog();
				for($q = 0; $q < count($queries); $q++) {
					$sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
					$logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
					$logs->write('SQL', $sql);
				}
			}

            if (!($filter_block=='' || $filter_block=='ALLBLOCK')) goto SELESAI; 
        /* READ */

		RENT:
        /* RENT */
            $SECTIONNAME = "RENT";
            $RENT_H_CountSuccess = $RENT_H_CountFailed = 0;
			if($this->debug) DB::enableQueryLog();
            
            $rent_day = 3;
			try {
				$rent_days  = DB::select("SELECT `value` FROM tparameter WHERE `name`='rent_book';");
				$rent_day   = $rent_days ? (int) $rent_days[0]->value : 3;
			} catch (\PDOException $e) {
				$logs->write("ERROR PARAMETER='rent_book'", $e->getMessage() ."\n");
			}

			$query = DB::table('trent_book as a')
				->select([
					'a.client_id',
					'a.user_id',
					'a.book_id',
					'a.start_date',
					'a.end_date'
				])
				->when(!$this->allclients, function ($query) use ($client_id) {
					return $query->where('a.client_id', $client_id);
				})
				->where('a.flag_end', 'N')
				->where('end_date', '<=', Carbon::now('Asia/Jakarta'))
				->get();

            try {
				$this->line("BEGIN => ". $SECTIONNAME);
				$row = count($query);
				$logs->write("Data", "[".$row."]");

                if ($row > 0) {
					$this->line("Found ". $row." Data" );

					foreach ($query as $value) {
						$update	= DB::table('trent_book')
						->where('client_id', $value->client_id)
						->where('user_id', $value->user_id)
						->where('book_id', $value->book_id)
						->update([
							'flag_end'  => 'Y',
							'updated_at' => $now
						]);
					}
                }else{
                    $this->line("No Data");  
                }

                $this->line("END => ". $SECTIONNAME."\r\n" );
            } catch (\PDOException $e_H) {
                $sqlState   = $e_H->errorInfo[0];
                $errCode    = $e_H->errorInfo[1];
                $errMessage = $e_H->errorInfo[2];

				$logs->write($SECTIONNAME, "ERROR ". $sqlState. " => ". $errMessage. "\n");
            }

			if($this->debug){
				$queries = DB::getQueryLog();
				for($q = 0; $q < count($queries); $q++) {
					$sql = Str::replaceArray('?', $queries[$q]['bindings'], str_replace('?', "'?'", $queries[$q]['query']));
					$logs->write('BINDING', '[' . implode(', ', $queries[$q]['bindings']) . ']');
					$logs->write('SQL', $sql);
				}
			}

            if (!($filter_block=='' || $filter_block=='ALLBLOCK')) goto SELESAI; 
        /* RENT */

		SELESAI:

        $logs->write("STOP", "\r\n");
    }
}
