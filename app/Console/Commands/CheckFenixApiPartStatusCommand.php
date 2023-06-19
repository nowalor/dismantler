<?php

namespace App\Console\Commands;

use App\Console\Commands\Base\FenixApiBaseCommand;
use Illuminate\Console\Command;

class CheckFenixApiPartStatusCommand extends FenixApiBaseCommand
{
    protected $signature = 'command:name';

    protected $description = 'Command description';

    public function handle()
    {
        return Command::SUCCESS;
    }
}
