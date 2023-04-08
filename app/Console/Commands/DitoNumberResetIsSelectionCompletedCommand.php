<?php

namespace App\Console\Commands;

use App\Models\DitoNumber;
use Illuminate\Console\Command;

class DitoNumberResetIsSelectionCompletedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return DitoNumber::query()
            ->update(['is_selection_completed' => false]);
    }
}
