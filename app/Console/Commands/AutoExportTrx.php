<?php

namespace App\Console\Commands;

use Storage;
use App\Logs;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AutoExportTrx extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ginesia:export-trx {BLOCK=USERS} {--debug} {--periode=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for update export transaction to ftp {BLOCK=which transaction to export} {--debug=print query to logs} {--periode=-1}';

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
		$this->periode		= $this->option('periode') !== '' ? now()->addMonths((int)$this->option('periode'))->format('Ym') : now()->format('Ym');

		$logs = new Logs($client_id.'_'.$this->periode.'_'.$nama_jobs.'_'.$filter_block);
        $logs->write('START', '');

		$ftp_host = env('FTP_HOST');
		$ftp_username = env('FTP_USERNAME');
		$ftp_password = env('FTP_PASSWORD');

		switch ($filter_block) {
            case 'USERS':
                goto USERS;
                break;

			case 'ATTR':
                goto ATTR;
                break;

			case 'READ':
                goto READ;
                break;

			case 'RENT':
                goto RENT;
                break;

			case 'VISIT':
                goto VISIT;
                break;
        }

        if (!($filter_block=='' || $filter_block=='ALLBLOCK')) goto SELESAI;

		USERS:
        /* USERS */
            $SECTIONNAME = "USERS";
			if($this->debug) DB::enableQueryLog();

			$query = DB::table('users as a')
				->select([
					'a.*'
				])
				->where(function($query) {
					$query->whereRaw("DATE_FORMAT(a.created_at, '%Y%m') = '".$this->periode."'")
						->orWhereRaw("DATE_FORMAT(a.updated_at, '%Y%m') = '".$this->periode."'");
				})
				->get();

            try {
				$this->line("BEGIN => ". $SECTIONNAME);

				$row = count($query);
				$logs->write("Data", "[".$row."]");

                if ($row > 0) {
					$file = storage_path("app/gns_".$this->periode."_usr.csv");
					$handle = fopen($file, 'w');

					fputcsv($handle, ['id', 'name', 'email', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at', 'role', 'client_id', 'flag_approve'], '|');

					foreach ($query as $value) {
						fputcsv($handle, [
							$value->id,
							$value->name,
							$value->email,
							$value->email_verified_at,
							$value->password,
							$value->remember_token,
							$value->created_at,
							$value->updated_at,
							$value->role,
							$value->client_id,
							$value->flag_approve
						], '|');
					}

					fclose($handle);

					$conn_id	= ftp_connect($ftp_host);
					$login		= ftp_login($conn_id, $ftp_username, $ftp_password);

					if ($login) {
						$remote_file = basename($file);

						if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
							$logs->write("Success", "File uploaded successfully to FTP server.");
						} else {
							$logs->write("Error", "uploading the file to FTP.");
						}

						ftp_close($conn_id);
					} else {
						$logs->write("Error", "FTP login failed.");
					}

					unlink($file);
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
        /* USERS */

		ATTR:
        /* ATTR */
            $SECTIONNAME = "ATTR";
			if($this->debug) DB::enableQueryLog();

			$query = DB::table('tattr_member as a')
				->select([
					'a.*',
					'b.email'
				])
				->join('users as b', function ($join) {
					$join->on('a.client_id', '=', 'b.client_id')
					->on('a.id', '=', 'b.id');
				})
				->where(function($query) {
					$query->whereRaw("DATE_FORMAT(a.created_at, '%Y%m') = '".$this->periode."'")
						->orWhereRaw("DATE_FORMAT(a.updated_at, '%Y%m') = '".$this->periode."'");
				})
				->get();

            try {
				$this->line("BEGIN => ". $SECTIONNAME);

				$row = count($query);
				$logs->write("Data", "[".$row."]");

                if ($row > 0) {
					$file = storage_path("app/gns_".$this->periode."_attr.csv");
					$handle = fopen($file, 'w');

					fputcsv($handle, ['id', 'client_id', 'nik', 'phone', 'birthday', 'photo', 'created_at', 'updated_at', 'gender', 'email'], '|');

					foreach ($query as $value) {
						fputcsv($handle, [
							$value->id,
							$value->client_id,
							$value->nik,
							$value->phone,
							$value->birthday,
							$value->photo,
							$value->created_at,
							$value->updated_at,
							$value->gender,
							$value->email
						], '|');
					}

					fclose($handle);

					$conn_id	= ftp_connect($ftp_host);
					$login		= ftp_login($conn_id, $ftp_username, $ftp_password);

					if ($login) {
						$remote_file = basename($file);

						if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
							$logs->write("Success", "File uploaded successfully to FTP server.");
						} else {
							$logs->write("Error", "uploading the file to FTP.");
						}

						ftp_close($conn_id);
					} else {
						$logs->write("Error", "FTP login failed.");
					}

					unlink($file);
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
        /* ATTR */

		READ:
        /* READ */
            $SECTIONNAME = "READ";
			if($this->debug) DB::enableQueryLog();

			$query = DB::table('ttrx_read as a')
				->select([
					'a.*',
					'b.email'
				])
				->join('users as b', function ($join) {
					$join->on('a.client_id', '=', 'b.client_id')
					->on('a.user_id', '=', 'b.id');
				})
				->whereRaw("DATE_FORMAT(a.start_read, '%Y%m') = '".$this->periode."'")
				->get();

            try {
				$this->line("BEGIN => ". $SECTIONNAME);

				$row = count($query);
				$logs->write("Data", "[".$row."]");

                if ($row > 0) {
					$file = storage_path("app/gns_".$this->periode."_read.csv");
					$handle = fopen($file, 'w');

					fputcsv($handle, ['id', 'user_id', 'client_id', 'start_read', 'end_read', 'created_at', 'updated_at', 'book_id', 'flag_end', 'email'], '|');

					foreach ($query as $value) {
						fputcsv($handle, [
							$value->id,
							$value->user_id,
							$value->client_id,
							$value->start_read,
							$value->end_read,
							$value->created_at,
							$value->updated_at,
							$value->book_id,
							$value->flag_end,
							$value->email
						], '|');
					}

					fclose($handle);

					$conn_id	= ftp_connect($ftp_host);
					$login		= ftp_login($conn_id, $ftp_username, $ftp_password);

					if ($login) {
						$remote_file = basename($file);

						if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
							$logs->write("Success", "File uploaded successfully to FTP server.");
						} else {
							$logs->write("Error", "uploading the file to FTP.");
						}

						ftp_close($conn_id);
					} else {
						$logs->write("Error", "FTP login failed.");
					}

					unlink($file);
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
			if($this->debug) DB::enableQueryLog();

			$query = DB::table('trent_book as a')
				->select([
					'a.*',
					'b.email'
				])
				->join('users as b', function ($join) {
					$join->on('a.client_id', '=', 'b.client_id')
					->on('a.user_id', '=', 'b.id');
				})
				->where(function($query) {
					$query->whereRaw("DATE_FORMAT(a.created_at, '%Y%m') = '".$this->periode."'")
						->orWhereRaw("DATE_FORMAT(a.updated_at, '%Y%m') = '".$this->periode."'");
				})
				->get();

            try {
				$this->line("BEGIN => ". $SECTIONNAME);

				$row = count($query);
				$logs->write("Data", "[".$row."]");

                if ($row > 0) {
					$file = storage_path("app/gns_".$this->periode."_rent.csv");
					$handle = fopen($file, 'w');

					fputcsv($handle, ['client_id', 'user_id', 'book_id', 'start_date', 'end_date', 'flag_end', 'created_at', 'updated_at', 'email'], '|');

					foreach ($query as $value) {
						fputcsv($handle, [
							$value->client_id,
							$value->user_id,
							$value->book_id,
							$value->start_date,
							$value->end_date,
							$value->flag_end,
							$value->created_at,
							$value->updated_at,
							$value->email
						], '|');
					}

					fclose($handle);

					$conn_id	= ftp_connect($ftp_host);
					$login		= ftp_login($conn_id, $ftp_username, $ftp_password);

					if ($login) {
						$remote_file = basename($file);

						if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
							$logs->write("Success", "File uploaded successfully to FTP server.");
						} else {
							$logs->write("Error", "uploading the file to FTP.");
						}

						ftp_close($conn_id);
					} else {
						$logs->write("Error", "FTP login failed.");
					}

					unlink($file);
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

		VISIT:
        /* VISIT */
            $SECTIONNAME = "VISIT";
			if($this->debug) DB::enableQueryLog();

			$query = DB::table('tvisitors as a')
				->select([
					'a.*'
				])
				->where(function($query) {
					$query->whereRaw("DATE_FORMAT(a.created_at, '%Y%m') = '".$this->periode."'")
						->orWhereRaw("DATE_FORMAT(a.updated_at, '%Y%m') = '".$this->periode."'");
				})
				->get();

            try {
				$this->line("BEGIN => ". $SECTIONNAME);

				$row = count($query);
				$logs->write("Data", "[".$row."]");

                if ($row > 0) {
					$file = storage_path("app/gns_".$this->periode."_visit.csv");
					$handle = fopen($file, 'w');

					fputcsv($handle, ['id', 'client_id', 'date', 'visitor', 'platform', 'device', 'browser', 'browser_name', 'user_agent', 'created_at', 'updated_at'], '|');

					foreach ($query as $value) {
						fputcsv($handle, [
							$value->id,
							$value->client_id,
							$value->date,
							$value->visitor,
							$value->platform,
							$value->device,
							$value->browser,
							$value->browser_name,
							$value->user_agent,
							$value->created_at,
							$value->updated_at
						], '|');
					}

					fclose($handle);

					$conn_id	= ftp_connect($ftp_host);
					$login		= ftp_login($conn_id, $ftp_username, $ftp_password);

					if ($login) {
						$remote_file = basename($file);

						if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
							$logs->write("Success", "File uploaded successfully to FTP server.");
						} else {
							$logs->write("Error", "uploading the file to FTP.");
						}

						ftp_close($conn_id);
					} else {
						$logs->write("Error", "FTP login failed.");
					}

					unlink($file);
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
        /* VISIT */

		SELESAI:

        $logs->write("STOP", "\r\n");
    }
}
