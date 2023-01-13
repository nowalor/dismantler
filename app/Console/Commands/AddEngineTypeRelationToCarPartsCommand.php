<?php

namespace App\Console\Commands;

use App\Models\CarPart;
use App\Models\EngineType;
use Illuminate\Console\Command;

class AddEngineTypeRelationToCarPartsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parts:add-engine-type';

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
        $parts = CarPart::all();

        foreach($parts as $part) {
            $engineType = EngineType::where('name', $part->engine_code)->first();

            if($engineType) {
                $part->engine_type_id = $engineType->id;
                $part->save();
            }
        }

        return Command::SUCCESS;
    }
}
