<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GermanDismantler;
use App\Models\DitoNumberGermanDismantler;
use Illuminate\Support\Facades\Log;

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

        $dismantlersUnique = $dismantlers->unique(function ($item) {
           return $item['hsn'].$item['tsn'];
       });

        $dismantlerDupes = $dismantlers->diff($dismantlersUnique);

        foreach($dismantlerDupes as $dismantler) {
            Log::info('deleting duplicate');
            $dismantlerToDelete = GermanDismantler::where('hsn', $dismantler->hsn)
                ->where('tsn', $dismantler->tsn);

            DitoNumberGermanDismantler::where('german_dismantler_id', $dismantlerToDelete->first()->id)
                ->delete();

           $dismantlerToDelete->first()->delete();
        }
    }
}
