<?php

namespace App\Actions\Ebay;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class ReadDeleteResponseAction
{
    private Filesystem $disk;

    public function __construct()
    {
        $this->disk = Storage::disk('ebay_sftp');
    }

    public function execute()
    {

        $today = now()->format('M-d-Y');
        $path = "/store/deleteInventory/$today";

//        $files =
    }
}
