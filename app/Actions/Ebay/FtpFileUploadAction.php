<?php

namespace App\Actions\Ebay;

use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
class FtpFileUploadAction
{
    private Filesystem $disk;

    public function __construct()
    {
        $this->disk = Storage::disk('ebay_sftp');
    }

    public function execute(
        string $to,
        string $file
    ): mixed
    {
        try {
            $response = $this->disk->put("$to/hello.xml", $file);

            if(!$response) {
                return 'no response';
            }
        } catch(\Exception $e) {
            return "catch {$e->getMessage()}";
        }

        return $response;
    }
}
