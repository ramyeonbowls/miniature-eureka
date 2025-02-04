<?php

namespace App\Console\Commands;

use Storage;
use App\Logs;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AutoImportTrx extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'ginesia:import-trx {--debug} {--periode=}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command for import transaction from ftp {--debug=print query to logs} {--periode=-1}';

	/**
	 * Execute the console command.
	 */
	public function handle()
	{
		$client_id          = config('app.client_id', '');
		$job_info           = pathinfo(__FILE__); 
		$nama_jobs          = $job_info['filename'];
		$now                = Carbon::now('Asia/Jakarta');
		$this->periode      = $this->option('periode') !== '' ? now()->addMonths((int)$this->option('periode'))->format('Ym') : now()->format('Ym');

		$logs = new Logs($client_id.'_'.$this->periode.'_'.$nama_jobs);
		$logs->write('START', '');

		$this->ftp_host = env('FTP_HOST');
		$this->ftp_username = env('FTP_USERNAME');
		$this->ftp_password = env('FTP_PASSWORD');

        $conn_id	= ftp_connect($this->ftp_host);
        $login		= ftp_login($conn_id, $this->ftp_username, $this->ftp_password);

        if ($login) {
            $folders = ftp_nlist($conn_id, '/');
            $logs->write("Start", "Download file to local");

            foreach ($folders as $client_id) {
if($client_id == '/pustakadigital'){
                if (ftp_chdir($conn_id, $client_id)) {
                    $logs->write("Info", "Changed to folder $client_id.");
                    $files = ftp_nlist($conn_id, '.');

                    if (!Storage::exists('Folder/' . $client_id . '/trx/')) {
                        Storage::makeDirectory('Folder/' . $client_id . '/trx/');
                    }

                    if (!Storage::exists('Folder/' . $client_id . '/trxHis/')) {
                        Storage::makeDirectory('Folder/' . $client_id . '/trxHis/');
                    }

                    if (!Storage::exists('Folder/' . $client_id . '/trxErr/')) {
                        Storage::makeDirectory('Folder/' . $client_id . '/trxErr/');
                    }

                    usort($files, function ($a, $b) {
                        return strpos($a, '_usr') === false ? 1 : (strpos($b, '_usr') === false ? -1 : 0);
                    });

                    // $logs->write("Info file", print_r($files, true));
                    foreach ($files as $file) {
                        $fileInfo   = pathinfo($file);
                        $filename   = $fileInfo['basename'];
                        $extension  = $fileInfo['extension'];

                        $fn         = explode('_', $filename);
                        $code       = $fn[0];
                        $periode    = $fn[1];
                        $block      = $fn[2];

                        if ($extension == 'csv' && $periode == $this->periode) {
                            $localFolder = storage_path('Folder/' . $client_id . '/trx/');
                            if (ftp_get($conn_id, $client_id ."/". $filename, $localFolder. $filename)) {
                                $logs->write("Success", "Download file $filename to $localFolder");
                            }else{
                                $logs->write("Error", "Failed to download file $filename. Source: $client_id/$filename, Destination: $localFolder$filename.");
                            }
                        }
                    }
                } else {
                    $logs->write("Error", "Failed to change directory to $client_id.");
                }
}
            }

            ftp_close($conn_id);
            $logs->write("Stop", "Download file to local");

            // $logs->write("Start", "Process file");
            // foreach ($folders as $client_id) {
            //     $logs->write("Start", "Read folder ". storage_path('Folder/' . $client_id . '/trx/'));
            //     $files = Storage::disk('local')->files('Folder/' . $client_id . '/trx/');
            //     foreach ($files as $file) {
            //         $logs->write("Start", "Read file". $file);
            //         $filecnt = file_get_contents(storage_path('app/' . $file));
            //         $logs->write("Data", print_r($filecnt, true));
            //     }
            // }
            // $logs->write("Stop", "Process file");
        } else {
            $logs->write("Error", "FTP login failed.");
        }

        $logs->write("STOP", "\r\n");
	}
}