<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GermanDismantler;
use App\Models\DitoNumberGermanDismantler;

class RemoveDuplicateGermanDismantlerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'german-dismantler-duplicates:remove';

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
        $dismantlers = GermanDismantler::all();

        foreach($dismantlers as $dismantler) {
            $uniqueDismantler = GermanDismantler::where('hsn', $dismantler->hsn)
                ->where('tsn', $dismantler->tsn);
            if($uniqueDismantler->get()->count() > 1) {
                DitoNumberGermanDismantler::where('german_dismantler_id', $uniqueDismantler->first()->id)
                    ->delete();
                $uniqueDismantler->first()->delete();
            }
        }
    }
}
