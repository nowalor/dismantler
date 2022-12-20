<?php

namespace App\Console\Commands;

use App\Models\DitoNumber;
use Illuminate\Console\Command;

class ReplaceDoubleSpacesInDitoNumberBrandCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dito-number:replace-double-spaces-in-brand';

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
        $ditoNumbers = DitoNumber::all();
        foreach ($ditoNumbers as $ditoNumber) {
            $ditoNumber->update(['brand' => str_replace('  ', ' ', $ditoNumber->brand)]);
        }

        return Command::SUCCESS;
    }
}
