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
        string $location,
        string $fileName,
    ): bool
    {
        try {
            $response = $this->disk->put("$to/$fileName",  file_get_contents($location));

        } catch(\Exception $e) {
            logger('in catch FtpFileUploadAction LINE 26');
            logger($e->getMessage());

            return false;
        }

        return $response;
    }
}
