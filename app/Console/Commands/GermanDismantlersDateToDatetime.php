<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GermanDismantler;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class GermanDismantlersDateToDatetime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dateformat:convert';

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

        $test = GermanDismantler::first();
        Log::info(Carbon::parse($test->date_of_allotment_of_type_code_number));
        foreach($dismantlers as &$dismantler) {
        Log::info($dismantler->date_of_allotment_of_type_code_number);
            if(strtotime($dismantler->date_of_allotment_of_type_code_number)) {
                $dismantler->date_of_allotment = Carbon::parse($dismantler->date_of_allotment_of_type_code_number);
                $dismantler->save();
            }
        }
    }
}
