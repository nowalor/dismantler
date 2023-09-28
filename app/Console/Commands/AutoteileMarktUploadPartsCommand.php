<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class AutoteileMarktUploadPartsCommand extends Command
{
    protected $signature = 'autoteile-markt:upload-parts';


    public function handle(): int
    {
        Storage::disk('ftp')->put(
            'import.csv',
            file_get_contents(base_path('public/exports/import.csv'))
        );


        return Command::SUCCESS;
    }
}
