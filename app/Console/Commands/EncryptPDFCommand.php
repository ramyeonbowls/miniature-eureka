<?php

namespace App\Console\Commands;

use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;

class EncryptPDFCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pdf:encrypt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Encrypt a PDF file with AES-256';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = public_path('storage/pdf');

        if (File::exists($path) && File::isDirectory($path)) {
            $files = File::files($path);

            foreach ($files as $file) {
                $this->info($file);

                // Get file content in memory
                $fileContent = Storage::get('public/pdf/5 Manfaat Daun Pandan yang Populer di Masyarakat.pdf');

                // Encrypt the File Content
                $encryptedContent = encrypt($fileContent);

                // Store the encrypted Content on Storage
                Storage::put('private/pdf/encrypt.gns', $encryptedContent);
            }
        } else {
            $this->error("Folder tidak ditemukan atau bukan folder yang valid.");
        }

        return 0;
    }
}
