<?php

namespace App\Actions\Ebay;

use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
class FtpFileUploadAction
{
    private Filesystem $disk;

    public function __construct()
    {
        $this->disk = Storage::disk('ebay_ftp');
    }

    public function execute(
        string $to,
        string $file
    ): void
    {
        $this->disk->put($to, $file);
    }
}
